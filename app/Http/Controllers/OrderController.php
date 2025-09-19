<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman detail produk untuk dipesan.
     */
    public function show(Product $product)
    {
        return view('product_detail', compact('product'));
    }

    /**
     * Menyimpan pesanan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'design_file' => 'nullable|file|mimes:jpg,png,jpeg,cdr,ai,psd|max:10240', // Max 10MB
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);

        $designFilePath = null;
        if ($request->hasFile('design_file')) {
            // Simpan file ke storage/app/public/designs
            // Nama file dibuat unik untuk menghindari konflik
            $fileName = time() . '_' . $request->file('design_file')->getClientOriginalName();
            $designFilePath = $request->file('design_file')->storeAs('designs', $fileName, 'public');
        }

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'notes' => $request->notes,
            'design_file' => $designFilePath,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
