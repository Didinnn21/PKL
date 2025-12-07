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
        // PERBAIKAN: Gunakan paginate() bukan get()
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('Member.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('Member.orders.show', compact('order'));
    }

    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== 'Menunggu Pembayaran') {
            return redirect()->route('member.orders.show', $id)
                ->with('error', 'Pesanan ini tidak dalam status menunggu pembayaran.');
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
            if ($order->payment_proof) {
                Storage::delete('public/' . $order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'Menunggu Verifikasi',
            ]);
        }

        return redirect()->route('member.orders.show', $id)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi Admin.');
    }
}
