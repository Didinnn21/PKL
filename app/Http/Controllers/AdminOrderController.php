<?php

namespace App\Http\Controllers; // <- Namespace utama

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        $orders = Order::with('user', 'product')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        $order->load('user', 'product');
        return view('admin.orders.show', compact('order'));
    }
}
