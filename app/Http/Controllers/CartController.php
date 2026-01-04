<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Mengambil item keranjang beserta data produk terkait
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // Mengarahkan ke folder view Member yang konsisten dengan rute Anda
        return view('Member.cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        // Menambahkan validasi 'size' agar wajib diisi
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string' // Wajib pilih ukuran
        ]);

        // Cek apakah produk dengan ID dan UKURAN yang sama sudah ada di keranjang
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('size', $request->size) // Memisahkan item berdasarkan ukuran
            ->first();

        if ($cartItem) {
            // Jika produk & ukuran sama, cukup tambahkan jumlahnya
            $cartItem->increment('quantity', $request->quantity);
        } else {
            // Jika produk atau ukuran berbeda, buat baris baru di database
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $request->size, // Menyimpan ukuran yang dipilih
            ]);
        }

        return redirect()->route('member.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        // Keamanan: Pastikan item keranjang benar milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('member.cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        // Keamanan: Pastikan item keranjang benar milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('member.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
