<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MemberProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk untuk member.
     */
    public function index()
    {
        // Ambil semua produk dari yang terbaru
        $products = Product::latest()->get();

        // Tampilkan view beserta data produk
        return view('Member.products.index', compact('products'));
    }
}
