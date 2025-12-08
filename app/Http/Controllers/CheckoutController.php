<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingService;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        // Anda dapat menambahkan logika untuk mengambil data ongkir dari API di sini
        $shippingOptions = [
            'JNE - REG' => 15000,
            'J&T - Express' => 16000,
            'SiCepat - REG' => 14000,
        ];
        $shippingOptions = ShippingService::all();
        return view('checkout.index', compact('cartItems', 'shippingOptions'));
    }
}
