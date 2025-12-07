<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_service' => 'required|string',
            'products'         => 'required|array',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        foreach ($cartItems as $item) {
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total_price' => $item->product->price * $item->quantity,
                'status' => 'Menunggu Pembayaran',
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $request->shipping_service,
                // Anda juga bisa menambahkan 'notes' dari form jika ada
            ]);
        }

        // Kosongkan keranjang setelah order dibuat
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan Anda telah berhasil dibuat!');
    }
}
