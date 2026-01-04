<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingService;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Tampilan Checkout Biasa (Dari Keranjang)
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('member.products.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $shippingOptions = ShippingService::all();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('Member.checkout.index', compact('cartItems', 'shippingOptions', 'total'));
    }

    /**
     * Tampilan Checkout Langsung (Tombol Beli Sekarang)
     */
    public function directCheckout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Membuat objek virtual agar seragam dengan tampilan keranjang
        $cartItems = collect([(object)[
            'product' => $product,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'product_id' => $product->id
        ]]);

        $shippingOptions = ShippingService::all();
        $total = $product->price * $request->quantity;
        $isDirect = true;

        return view('Member.checkout.index', compact('cartItems', 'shippingOptions', 'total', 'isDirect'));
    }

    /**
     * MEMPROSES PESANAN (Fungsi yang sebelumnya hilang)
     */
    public function process(Request $request)
    {
        // 1. Validasi Input dari Form Checkout
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_service' => 'required|exists:shipping_services,id',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $shipping = ShippingService::findOrFail($request->shipping_service);

            // 2. Ambil data item yang akan dibeli
            // Logika ini menangani checkout dari keranjang
            $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('member.products.index')->with('error', 'Pesanan tidak ditemukan.');
            }

            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $grandTotal = $subtotal + $shipping->price;

            // 3. Simpan ke Tabel Orders
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_price' => $grandTotal,
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $shipping->name,
                'shipping_cost' => $shipping->price,
                'status' => 'unpaid', // Status awal
            ]);

            // 4. Simpan tiap item ke Tabel OrderItems
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // 5. Kosongkan Keranjang Belanja
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
