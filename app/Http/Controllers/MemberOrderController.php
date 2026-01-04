<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MemberOrderController extends Controller
{
    /**
     * Daftar status yang mengizinkan member untuk melakukan edit atau hapus.
     */
    protected $editableStatuses = [
        'pending',
        'unpaid',
        'Belum Dibayar',
        'Menunggu Pembayaran',
        'MENUNGGU PEMBAYARAN',
        'pending_quote'
    ];

    /**
     * Menampilkan Riwayat Pesanan
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'product'])
            ->latest()
            ->paginate(10);

        return view('Member.orders.index', compact('orders'));
    }

    /**
     * Menampilkan Detail Pesanan
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'product'])
            ->findOrFail($id);

        return view('Member.orders.show', compact('order'));
    }

    /**
     * Membatalkan Pesanan
     */
    public function destroy($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array($order->status, $this->editableStatuses)) {
            return back()->with('error', 'Pesanan yang sedang diproses tidak dapat dibatalkan.');
        }

        try {
            DB::beginTransaction();

            if ($order->design_file && Storage::disk('public')->exists($order->design_file)) {
                Storage::disk('public')->delete($order->design_file);
            }
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $order->items()->delete();
            $order->delete();

            DB::commit();
            return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan pesanan.');
        }
    }

    /**
     * Form Upload Bukti Pembayaran
     */
    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->order_type == 'custom' && $order->total_price <= 0) {
            return redirect()->route('member.orders.show', $id)
                ->with('error', 'Mohon tunggu admin memberikan harga sebelum membayar.');
        }

        if (!in_array($order->status, $this->editableStatuses)) {
            return redirect()->route('member.orders.show', $id)->with('error', 'Status tidak valid.');
        }

        return view('Member.orders.payment', compact('order'));
    }

    /**
     * Simpan Bukti Pembayaran
     */
    public function updatePayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'Menunggu Verifikasi',
            ]);
        }

        return redirect()->route('member.orders.index')->with('success', 'Bukti berhasil diunggah!');
    }
}
