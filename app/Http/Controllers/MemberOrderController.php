<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberOrderController extends Controller
{
    /**
     * DAFTAR STATUS YANG VALID UNTUK DIUBAH/DAPAT DIUPLOAD BUKTI BAYAR
     * Sesuaikan dengan 'status' => 'unpaid' yang ada di CheckoutController Anda.
     */
    protected $editableStatuses = ['pending', 'unpaid', 'Belum Dibayar', 'Menunggu Pembayaran', 'MENUNGGU PEMBAYARAN'];

    public function index()
    {
        // Mengambil semua pesanan milik member yang sedang login
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'product']) // Eager loading produk utama dan detail item
            ->latest() // Menampilkan pesanan terbaru di paling atas
            ->paginate(10); // Pagination agar tampilan rapi

        return view('Member.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'product'])
            ->findOrFail($id);

        return view('Member.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Validasi apakah status pesanan masih boleh dihapus
        if (!in_array($order->status, $this->editableStatuses)) {
            return back()->with('error', 'Pesanan yang sedang diproses oleh admin tidak dapat dibatalkan.');
        }

        // Hapus file desain dan bukti pembayaran dari storage jika ada
        if ($order->design_file) {
            Storage::disk('public')->delete($order->design_file);
        }
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        // Hapus detail barang dan pesanan utama
        $order->items()->delete();
        $order->delete();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan Anda telah berhasil dibatalkan.');
    }

    public function edit($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array($order->status, $this->editableStatuses)) {
            return redirect()->route('member.orders.index')->with('error', 'Pesanan sudah diproses admin.');
        }

        return view('Member.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'notes' => 'nullable|string',
        ]);

        $order->update([
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
        ]);

        return redirect()->route('member.orders.index')->with('success', 'Informasi pengiriman berhasil diperbarui.');
    }

    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Memastikan status pesanan adalah status yang membutuhkan pembayaran
        if (!in_array($order->status, $this->editableStatuses)) {
            return redirect()->route('member.orders.show', $id)
                ->with('error', 'Pesanan ini sudah dibayar atau sedang dalam proses verifikasi.');
        }

        return view('Member.orders.payment', compact('order'));
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Hapus bukti bayar lama jika ada (kasus re-upload)
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            // Simpan file ke folder payment-proofs di storage public
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'Menunggu Verifikasi', // Status berubah agar admin bisa mengecek
            ]);
        }

        return redirect()->route('member.orders.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu admin melakukan verifikasi.');
    }
}
    