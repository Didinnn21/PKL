<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * 1. Menampilkan Halaman Form Custom Order (Member)
     * Method ini yang dipanggil saat klik "Pesan Custom" di sidebar member
     */
    public function createCustom()
    {
        // Menampilkan view form custom order
        return view('Member.orders.custom');
    }

    /**
     * 2. Menyimpan order dari proses Checkout (Keranjang Belanja)
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_service' => 'required|string',
            'products'         => 'required|array', // Validasi produk dikirim dari checkout
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
            ]);
        }

        // Kosongkan keranjang setelah order dibuat
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan Anda telah berhasil dibuat!');
    }

    /**
     * 3. Menyimpan Custom Order (Baik dari Landing Page maupun Dashboard Member)
     */
    public function storeCustom(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:5048', // Max 5MB
            'quantity'    => 'required|integer|min:1',
        ]);

        // Upload Gambar Desain
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Gambar akan disimpan di storage/app/public/custom-designs
            // Pastikan Anda sudah menjalankan: php artisan storage:link
            $imagePath = $request->file('image')->store('custom-designs', 'public');
        }

        // Buat Pesanan
        Order::create([
            'user_id'     => Auth::id(),
            'product_id'  => null, // Null karena ini custom
            'quantity'    => $request->quantity,
            'total_price' => 0, // Harga 0 dulu karena perlu negosiasi/konfirmasi admin
            'status'      => 'Menunggu Konfirmasi',
            'notes'       => "CUSTOM ORDER\nNama Produk: " . $request->name . "\nDeskripsi: " . $request->description,
            'design_file' => $imagePath,
            'shipping_address' => '-', // Bisa diupdate nanti oleh user/admin
            'shipping_service' => '-',
        ]);

        // Redirect kembali dengan pesan sukses
        // Jika request datang dari dashboard member, arahkan ke riwayat pesanan
        if ($request->routeIs('member.*') || $request->is('member/*')) {
            return redirect()->route('member.orders.index')->with('success', 'Pesanan Custom berhasil dikirim! Silakan cek status secara berkala.');
        }

        // Jika dari landing page, kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Pesanan Custom berhasil dikirim! Silakan cek dashboard member Anda.');
    }
}
