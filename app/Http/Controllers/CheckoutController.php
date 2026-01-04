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
     * Tampilan Checkout dari Keranjang
     */
    public function index()
    {
        // Pastikan eager loading product agar harga bisa diakses
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
     * Tampilan Checkout Langsung (Beli Sekarang)
     */
    public function directCheckout(Request $request)
    {
        // Mendukung GET jika user refresh halaman dengan mengecek session
        if ($request->isMethod('get') && !session()->has('direct_checkout')) {
            return redirect()->route('member.products.index');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);

            // Simpan data ke session untuk diproses di fungsi process()
            session(['direct_checkout' => [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]]);
        }

        $directData = session('direct_checkout');
        $product = Product::findOrFail($directData['product_id']);

        // Format koleksi agar serupa dengan struktur Cart
        $cartItems = collect([(object)[
            'product' => $product,
            'quantity' => $directData['quantity'],
            'price' => $product->price,
            'product_id' => $product->id
        ]]);

        $shippingOptions = ShippingService::all();
        $total = $product->price * $directData['quantity'];

        return view('Member.checkout.index', compact('cartItems', 'shippingOptions', 'total'))->with('isDirect', true);
    }

    /**
     * Memproses Penyimpanan Pesanan ke Database
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_service' => 'required|exists:shipping_services,id',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $shipping = ShippingService::findOrFail($request->shipping_service);
            $itemsToOrder = collect();
            $subtotal = 0;
            $productIdForOrder = null;
            $quantityForOrder = null;

            // 1. Tentukan sumber item: Checkout Langsung atau Keranjang
            if (session()->has('direct_checkout')) {
                $directData = session('direct_checkout');
                $product = Product::findOrFail($directData['product_id']);

                $itemsToOrder->push((object)[
                    'product_id' => $product->id,
                    'quantity' => $directData['quantity'],
                    'price' => $product->price
                ]);

                $subtotal = $product->price * $directData['quantity'];

                // Simpan data untuk kolom di tabel orders (jika ada)
                $productIdForOrder = $product->id;
                $quantityForOrder = $directData['quantity'];
            } else {
                $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('member.products.index')->with('error', 'Pesanan tidak ditemukan.');
                }

                foreach ($cartItems as $cartItem) {
                    $itemsToOrder->push((object)[
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->price
                    ]);
                }

                $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            }

            $grandTotal = $subtotal + $shipping->price;

            // 2. Simpan ke Tabel Orders
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'product_id'       => $productIdForOrder, // Terisi jika direct checkout
                'quantity'         => $quantityForOrder,  // Terisi jika direct checkout
                'total_price'      => $grandTotal,
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $shipping->name,
                'shipping_cost'    => $shipping->price,
                'status'           => 'unpaid',
                'order_type'       => 'regular',
            ]);

            // 3. Simpan ke Tabel OrderItems
            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                ]);
            }

            // 4. Bersihkan data setelah berhasil
            if (session()->has('direct_checkout')) {
                session()->forget('direct_checkout');
            } else {
                Cart::where('user_id', $user->id)->delete();
            }

            DB::commit();

            return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
