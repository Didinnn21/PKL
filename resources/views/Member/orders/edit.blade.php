<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan member dengan Pagination.
     */
    public function index()
    {
        // Mengambil data order milik member dengan memuat relasi items dan product
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('Member.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Memastikan relasi produk ikut terload agar tidak error di halaman detail
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->findOrFail($id);

        return view('Member.orders.show', compact('order'));
    }

    /**
     * Menghapus pesanan (Hanya jika belum dibayar)
     */
    public function destroy($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Perbaikan: Gunakan array untuk mengecek berbagai kemungkinan string status yang Anda gunakan
        $allowedStatuses = ['pending', 'Belum Dibayar', 'Menunggu Pembayaran'];
        if (!in_array($order->status, $allowedStatuses)) {
            return back()->with('error', 'Pesanan yang sudah diproses tidak dapat dihapus.');
        }

        // Hapus file desain custom jika ada agar tidak memenuhi storage
        if ($order->design_file) {
            Storage::disk('public')->delete($order->design_file);
        }

        // Hapus bukti pembayaran jika user pernah upload tapi lalu ingin hapus pesanan
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        // Hapus detail item terlebih dahulu baru pesanan utamanya
        $order->items()->delete();
        $order->delete();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibatalkan dan dihapus.');
    }

    /**
     * Menampilkan halaman edit (Alamat & Catatan)
     */
    public function edit($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $allowedStatuses = ['pending', 'Belum Dibayar', 'Menunggu Pembayaran'];
        if (!in_array($order->status, $allowedStatuses)) {
            return redirect()->route('member.orders.index')->with('error', 'Pesanan ini sudah dalam proses.');
        }

        return view('Member.orders.edit', compact('order'));
    }

    /**
     * Memperbarui data alamat atau catatan pesanan
     */
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

        return redirect()->route('member.orders.index')->with('success', 'Detail pengiriman berhasil diperbarui.');
    }

    /**
     * Halaman Unggah Bukti Pembayaran
     */
    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $allowedStatuses = ['pending', 'Belum Dibayar', 'Menunggu Pembayaran'];
        if (!in_array($order->status, $allowedStatuses)) {
            return redirect()->route('member.orders.show', $id)
                ->with('error', 'Status pesanan tidak memungkinkan untuk upload bukti bayar.');
        }

        return view('Member.orders.payment', compact('order'));
    }

    /**
     * Proses Unggah Bukti Pembayaran
     */
    public function updatePayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Bersihkan file lama jika user mengupload ulang bukti bayar
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'Menunggu Verifikasi', // Status berpindah ke admin untuk dicek
            ]);
        }

        return redirect()->route('member.orders.index')
            ->with('success', 'Bukti berhasil diunggah! Admin akan segera memverifikasi pesanan Anda.');
    }
}
