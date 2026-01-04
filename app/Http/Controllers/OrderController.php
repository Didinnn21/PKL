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
        // --- PERBAIKAN DI SINI ---
        // Saya menghapus 'products' => 'required' karena kita ambil dari DB Cart
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_service' => 'required|string',
            'design_file'      => 'nullable|file|mimes:jpeg,png,jpg,pdf,ai,psd,cdr|max:5120',
            'notes'            => 'nullable|string',
        ]);

        $user = Auth::user();

        // Ambil item dari database keranjang, bukan dari input form
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        // Ambil Data Jasa Kirim
        $serviceName = $request->shipping_service;
        $shippingService = ShippingService::where('name', $serviceName)->first();
        $shippingCost = $shippingService ? $shippingService->price : 0;

        // Format teks jasa kirim
        $shippingLabel = $serviceName . ' (Rp ' . number_format($shippingCost, 0, ',', '.') . ')';

        // Proses Upload File Desain (Jika Ada)
        $designPath = null;
        if ($request->hasFile('design_file')) {
            $designPath = $request->file('design_file')->store('designs', 'public');
        }

        // Loop Simpan Pesanan
        foreach ($cartItems as $index => $item) {
            $productTotal = $item->product->price * $item->quantity;

            // Ongkir hanya masuk ke item pertama agar tidak double charge
            $finalTotal = $productTotal;
            $currentShippingLabel = $shippingLabel;

            if ($index === 0) {
                $finalTotal += $shippingCost;
            } else {
                $currentShippingLabel = $serviceName . ' (Digabung)';
            }

            Order::create([
                'user_id'          => $user->id,
                'product_id'       => $item->product_id,
                'quantity'         => $item->quantity,
                'total_price'      => $finalTotal,
                'status'           => 'Menunggu Pembayaran',
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $currentShippingLabel,
                'notes'            => $request->notes ?? '-',
                'design_file'      => $designPath,
                'payment_proof'    => null,
            ]);
        }

        // Bersihkan Keranjang
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
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

        // Gabungkan array ukuran menjadi string agar mudah dibaca admin
        // Hasilnya misal: "S:10, M:20, L:5"
        $rincianSize = [];
        foreach ($request->sizes as $index => $size) {
            $qty = $request->quantities[$index];
            $rincianSize[] = "$size:$qty";
        }
        $sizeString = implode(', ', $rincianSize);

        // Simpan file desain
        $filePath = $request->file('design_file')->store('custom_designs', 'public');

        // Simpan pesanan
        \App\Models\Order::create([
            'user_id'      => auth()->id(),
            'order_type'   => 'custom',
            'product_type' => $request->product_type,
            'size'         => $sizeString, // Menyimpan rincian gabungan
            'quantity'     => array_sum($request->quantities), // Total seluruh qty
            'design_file'  => $filePath,
            'notes'        => $request->notes,
            'status'       => 'pending_quote',
            'total_price'  => 0,
        ]);

        return redirect()->route('member.orders.index')->with('success', 'Pengajuan custom grosir berhasil dikirim!');
    }
}
