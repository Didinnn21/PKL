<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        // Ambil 8 produk terbaru dari database untuk ditampilkan
        $products = Product::latest()->take(8)->get();

        // Kirim data produk ke view 'home'
        return view('home', compact('products'));
    }

    /**
     * Menampilkan halaman detail untuk satu produk.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product-show', compact('product'));
    }

    /**
     * Menampilkan halaman daftar semua produk.
     */
    public function products()
    {
        $products = Product::latest()->paginate(12); // Menampilkan 12 produk per halaman
        return view('products-all', compact('products')); // Anda perlu membuat view 'products-all.blade.php'
    }

    /**
     * Menangani pencarian.
     */
    public function search(Request $request)
    {
        // pencarian produk
        $query = $request->input('q');
        return "Halaman Hasil Pencarian untuk: " . $query;
    }


    public function addToCart(Request $request)
    {
        // menambah ke keranjang
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menampilkan keranjang belanja.
     */
    public function viewCart()
    {
        return "Ini adalah halaman Keranjang Belanja (Cart)";
    }

    /**
     * Menampilkan halaman checkout.
     */
    public function checkout()
    {
        return "Ini adalah halaman Checkout";
    }

    /**
     * Menampilkan halaman wishlist.
     */
    public function wishlist()
    {
        return "Ini adalah halaman Wishlist";
    }
}
