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
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Tampilan Checkout dari Keranjang
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('member.products.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $shippingOptions = ShippingService::all();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('Member.checkout.index', compact('cartItems', 'shippingOptions', 'total'));
    }

    /**
     * Tampilan Checkout Langsung (Beli Sekarang)
     */
    public function directCheckout(Request $request)
    {
        if ($request->isMethod('get') && !session()->has('direct_checkout')) {
            return redirect()->route('member.products.index');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);
            session(['direct_checkout' => [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]]);
        }

        $directData = session('direct_checkout');
        $product = Product::findOrFail($directData['product_id']);

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

            // 1. Ambil data dari Session (Direct) atau DB (Cart)
            if (session()->has('direct_checkout')) {
                $directData = session('direct_checkout');
                $product = Product::findOrFail($directData['product_id']);

                $itemsToOrder->push((object)[
                    'product_id' => $product->id,
                    'quantity' => $directData['quantity'],
                    'price' => $product->price
                ]);

                $subtotal = $product->price * $directData['quantity'];
                $productIdForOrder = $product->id;
                $quantityForOrder = $directData['quantity'];
            } else {
                $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
                if ($cartItems->isEmpty()) {
                    return redirect()->route('member.products.index')->with('error', 'Item tidak ditemukan.');
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

            // 2. Generate Data Wajib
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // 3. Simpan Pesanan Utama (Order)
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => $orderNumber,
                'product_id'       => $productIdForOrder,
                'quantity'         => $quantityForOrder,
                'total_price'      => $subtotal + $shipping->price,
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $shipping->name,
                'shipping_cost'    => $shipping->price,
                'status'           => 'unpaid',
                'order_type'       => 'regular',
                'notes'            => $request->notes ?? '-', // Hindari NULL jika kolom wajib diisi
            ]);

            // 4. Simpan Detail Item (OrderItem)
            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                ]);
            }

            // 5. Cleanup
            if (session()->has('direct_checkout')) {
                session()->forget('direct_checkout');
            } else {
                Cart::where('user_id', $user->id)->delete();
            }

            DB::commit();
            return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Catat error ke log agar bisa kita telusuri di storage/logs/laravel.log
            Log::error('Gagal Checkout: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
