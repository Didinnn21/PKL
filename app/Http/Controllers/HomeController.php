<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(8)->get();
        return view('home', compact('products'));
    }

    public function showProductDetail($id)
    {
        $product = Product::findOrFail($id);
        return view('product_detail', compact('product'));
    }
}
