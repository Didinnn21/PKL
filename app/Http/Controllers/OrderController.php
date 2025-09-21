<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menyimpan pesanan baru yang dibuat oleh member.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            // Validasi file: wajib file, jenis tertentu, ukuran maks 3MB
            'design_file' => 'nullable|file|mimes:jpg,png,jpeg,cdr,ai,psd|max:3048',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;

        $designFilePath = null;
        if ($request->hasFile('design_file')) {
            // Simpan file ke storage/app/public/designs
            $designFilePath = $request->file('design_file')->store('designs', 'public');
        }

        // Buat pesanan baru di database
        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'Menunggu Pembayaran', // Status awal pesanan
            'notes' => $request->notes,
            'design_file' => $designFilePath,
            // Anda bisa tambahkan 'shipping_address' di sini jika sudah ada field-nya di form
        ]);

        // Arahkan ke dashboard member dengan pesan sukses
        return redirect()->route('member.dashboard')->with('success', 'Pesanan Anda telah berhasil dibuat!');
    }
}
