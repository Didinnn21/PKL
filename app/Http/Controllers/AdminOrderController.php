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
    // app/Http/Controllers/AdminOrderController.php

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status'      => 'required|string|in:Menunggu Penawaran,Menunggu Pembayaran,Menunggu Verifikasi,Diproses,Dikirim,Selesai,Dibatalkan',
            'total_price' => 'nullable|integer|min:0',
        ]);

        $data = ['status' => $request->status];

        if ($order->order_type === 'custom' && $request->has('total_price')) {
            $data['total_price'] = $request->total_price;
        }

        $order->update($data);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
