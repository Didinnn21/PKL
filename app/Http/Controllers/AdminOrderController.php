<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan
     */
    public function index()
    {
        // Menampilkan list order dari yang terbaru
        $orders = Order::with('user')->latest()->paginate(15);
        return view('Admin.Orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show(Order $order) // Laravel otomatis mencari ID order
    {
        // PERBAIKAN DI SINI:
        // Kita menggunakan $order yang sudah ditangkap oleh parameter di atas.
        // Kita gunakan 'load' untuk mengambil relasi User dan OrderItems (beserta produknya)

        $order->load(['user', 'orderItems.product']);

        return view('Admin.Orders.show', compact('order'));
    }

    /**
     * Update status pesanan (Fitur Baru)
     */
    public function update(Request $request, Order $order)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|string|in:Menunggu Pembayaran,Menunggu Verifikasi,Diproses,Dikirim,Selesai,Dibatalkan',
        ]);

        // Update database
        $order->update([
            'status' => $request->status
        ]);

        // Kembali ke halaman detail dengan pesan sukses
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi: ' . $request->status);
    }
}
