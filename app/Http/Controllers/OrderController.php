<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * 1. Menampilkan Halaman Form Custom Order (Member)
     */
    public function createCustom()
    {
        return view('Member.orders.custom');
    }

    /**
     * 2. Menyimpan order dari proses Checkout (Keranjang Belanja)
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_service' => 'required|string',
            'design_file'      => 'nullable|file|mimes:jpeg,png,jpg,pdf,ai,psd,cdr|max:5120',
            'notes'            => 'nullable|string',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $serviceName = $request->shipping_service;
        $shippingService = ShippingService::where('name', $serviceName)->first();
        $shippingCost = $shippingService ? $shippingService->price : 0;
        $shippingLabel = $serviceName . ' (Rp ' . number_format($shippingCost, 0, ',', '.') . ')';

        $designPath = null;
        if ($request->hasFile('design_file')) {
            $designPath = $request->file('design_file')->store('designs', 'public');
        }

        // Generate satu nomor pesanan untuk seluruh keranjang
        $orderGroupNumber = 'ORD-' . strtoupper(uniqid());

        foreach ($cartItems as $index => $item) {
            $productTotal = $item->product->price * $item->quantity;
            $finalTotal = $productTotal;
            $currentShippingLabel = $shippingLabel;

            if ($index === 0) {
                $finalTotal += $shippingCost;
            } else {
                $currentShippingLabel = $serviceName . ' (Digabung)';
            }

            Order::create([
                'user_id'          => $user->id,
                'order_number'     => $orderGroupNumber, // TAMBAHKAN INI
                'product_id'       => $item->product_id,
                'quantity'         => $item->quantity,
                'total_price'      => $finalTotal,
                'status'           => 'Menunggu Pembayaran',
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $currentShippingLabel,
                'notes'            => $request->notes ?? '-',
                'design_file'      => $designPath,
                'order_type'       => 'regular', // Pastikan tipe tercatat
            ]);
        }

        Cart::where('user_id', $user->id)->delete();
        return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * 3. Menyimpan Custom Order
     */
    public function storeCustom(Request $request)
    {
        $request->validate([
            'product_type' => 'required',
            'sizes'        => 'required|array',
            'quantities'   => 'required|array',
            'design_file'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes'        => 'required'
        ]);

        $rincianSize = [];
        foreach ($request->sizes as $index => $size) {
            $qty = $request->quantities[$index];
            $rincianSize[] = "$size:$qty";
        }
        $sizeString = implode(', ', $rincianSize);

        $filePath = $request->file('design_file')->store('custom_designs', 'public');

        // PERBAIKAN: Generate nomor pesanan khusus custom
        $customOrderNumber = 'ORD-CUST-' . strtoupper(uniqid());

        // Simpan pesanan
        Order::create([
            'user_id'      => auth()->id(),
            'order_number' => $customOrderNumber, // PERBAIKAN: Field ini sekarang terisi
            'order_type'   => 'custom',
            'product_type' => $request->product_type,
            'size'         => $sizeString,
            'quantity'     => array_sum($request->quantities),
            'design_file'  => $filePath,
            'notes'        => $request->notes,
            'status'       => 'pending_quote',
            'total_price'  => 0,
        ]);

        return redirect()->route('member.orders.index')->with('success', 'Pengajuan custom grosir berhasil dikirim!');
    }
}
