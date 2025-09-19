<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url'
        ]);

        Product::create($request->all());

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk yang ada.
     */
    public function edit(Product $product)
    {
        // Laravel secara otomatis akan menemukan produk berdasarkan ID dari URL
        // lalu mengirimkannya sebagai variabel $product ke view.
        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, Product $product)
    {
        // Lakukan validasi yang sama seperti saat membuat
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url'
        ]);

        // Update data produk dengan data baru dari form
        $product->update($request->all());

        // Arahkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('dashboard.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
