<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart; // Pastikan model Cart di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menyimpan pesanan baru dari keranjang belanja (proses checkout).
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form checkout
        $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'shipping_service' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'design_file' => 'nullable|file|mimes:jpg,png,jpeg,cdr,ai,psd|max:3048', // max 3MB
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        // 2. Cek apakah keranjang kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('member.cart.index')->with('error', 'Keranjang Anda kosong! Silakan tambahkan produk terlebih dahulu.');
        }

        $designFilePath = null;
        if ($request->hasFile('design_file')) {
            // 3. Simpan file desain jika diunggah
            $designFilePath = $request->file('design_file')->store('designs', 'public');
        }

        // 4. Proses setiap item di keranjang untuk dibuatkan order
        foreach ($cartItems as $item) {
            // Validasi stok sebelum membuat pesanan
            if (!$item->product || $item->product->stock < $item->quantity) {
                return redirect()->route('member.cart.index')->with('error', "Stok produk '{$item->product->name}' tidak mencukupi.");
            }

            Order::create([
                'user_id'          => $user->id,
                'product_id'       => $item->product_id,
                'quantity'         => $item->quantity,
                'total_price'      => $item->product->price * $item->quantity,
                'status'           => 'Menunggu Pembayaran', // Status awal pesanan
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $request->shipping_service,
                'notes'            => $request->notes,
                'design_file'      => $designFilePath,
            ]);

            // Kurangi stok produk setelah pesanan dibuat
            $item->product->decrement('stock', $item->quantity);
        }

        // 5. Kosongkan keranjang setelah semua pesanan berhasil dibuat
        Cart::where('user_id', $user->id)->delete();

        // 6. halaman riwayat pesanan dengan pesan sukses
        return redirect()->route('member.orders.index')->with('success', 'Pesanan Anda telah berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
