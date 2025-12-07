<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        // Pastikan Anda memiliki view 'cart.index'
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        // PERBAIKAN: Mengarahkan ke nama rute yang benar
        return redirect()->route('member.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        // Pastikan cart yang diupdate milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        // PERBAIKAN: Mengarahkan ke nama rute yang benar
        return redirect()->route('member.cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        // Pastikan cart yang dihapus milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        // PERBAIKAN: Mengarahkan ke nama rute yang benar
        return redirect()->route('member.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
