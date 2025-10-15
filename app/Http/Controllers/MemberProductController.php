<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MemberProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Logika Pencarian (jika Anda ingin menambahkannya nanti)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // 2. Logika Filter Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // 3. Logika Pengurutan
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort == 'terbaru') {
                $query->latest();
            } elseif ($sort == 'harga_terendah') {
                $query->orderBy('price', 'asc');
            } elseif ($sort == 'harga_tertinggi') {
                $query->orderBy('price', 'desc');
            }
        } else {
            // Urutan default jika tidak ada pilihan
            $query->latest();
        }

        // 4. Paginasi untuk membatasi jumlah produk per halaman
        $products = $query->paginate(9)->withQueryString();

        return view('Member.products.index', compact('products'));
    }
}
