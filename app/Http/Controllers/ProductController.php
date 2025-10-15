<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk manajemen file

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('Admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('Admin.products.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi diubah untuk menerima file gambar
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Diubah dari 'image_url'
        ]);

        // 2. Proses upload file gambar
        $path = $request->file('image')->store('public/products');
        $imageUrl = Storage::url($path);

        // 3. Simpan data ke database
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $imageUrl, // Simpan URL yang bisa diakses publik
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('Admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar tidak wajib saat update
        ]);

        $imageUrl = $product->image_url;
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($product->image_url) {
                // Konversi URL publik kembali ke path storage
                $oldPath = str_replace('/storage', 'public', $product->image_url);
                Storage::delete($oldPath);
            }
            // Upload gambar baru
            $path = $request->file('image')->store('public/products');
            $imageUrl = Storage::url($path);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus file gambar dari storage sebelum menghapus data produk
        if ($product->image_url) {
            $path = str_replace('/storage', 'public', $product->image_url);
            Storage::delete($path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
