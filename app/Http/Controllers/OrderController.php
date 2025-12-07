<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\ShippingService; // Import Model Jasa Kirim
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
        // Validasi Input
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_service' => 'required|string', // Berisi nama service, misal: "JNE - REG"
            'products'         => 'required|array',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        // --- LOGIKA ONGKOS KIRIM ---
        // Cari data jasa kirim di database berdasarkan nama yang dipilih
        $serviceName = $request->shipping_service;
        $shippingService = ShippingService::where('name', $serviceName)->first();

        // Ambil harganya (jika tidak ditemukan, default 0)
        $shippingCost = $shippingService ? $shippingService->price : 0;

        // Format text untuk disimpan, misal: "JNE - REG (Rp 15.000)"
        $shippingLabel = $serviceName . ' (Rp ' . number_format($shippingCost, 0, ',', '.') . ')';

        // --- PROSES PEMBUATAN ORDER ---
        foreach ($cartItems as $index => $item) {

            // Hitung subtotal barang (Harga x Jumlah)
            $productTotal = $item->product->price * $item->quantity;

            // LOGIKA PENTING:
            // Ongkir hanya dibebankan PADA ITEM PERTAMA agar tidak double charge
            // Jika ada 3 barang, ongkir 15rb hanya masuk ke order barang ke-1.
            $finalTotal = $productTotal;
            $currentShippingLabel = $shippingLabel;

            if ($index === 0) {
                $finalTotal += $shippingCost; // Tambah ongkir di item pertama
            } else {
                // Item selanjutnya ongkirnya dianggap 0 atau "Digabung"
                $currentShippingLabel = $serviceName . ' (Digabung dengan item utama)';
            }

            Order::create([
                'user_id'          => $user->id,
                'product_id'       => $item->product_id,
                'quantity'         => $item->quantity,
                'total_price'      => $finalTotal, // Harga Produk + Ongkir (jika item pertama)
                'status'           => 'Menunggu Pembayaran',
                'shipping_address' => $request->shipping_address,
                'shipping_service' => $currentShippingLabel,
                'notes'            => $request->notes ?? '-',
            ]);
        }

        // Kosongkan keranjang
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * 3. Menyimpan Custom Order
     */
    public function storeCustom(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'quantity'    => 'required|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('custom-designs', 'public');
        }

        Order::create([
            'user_id'     => Auth::id(),
            'product_id'  => null,
            'quantity'    => $request->quantity,
            'total_price' => 0, // Harga ditentukan Admin nanti
            'status'      => 'Menunggu Konfirmasi',
            'notes'       => "CUSTOM ORDER\nJudul: " . $request->name . "\nDetail: " . $request->description,
            'design_file' => $imagePath,
            'shipping_address' => '-',
            'shipping_service' => '-',
        ]);

        if ($request->routeIs('member.*') || $request->is('member/*')) {
            return redirect()->route('member.orders.index')->with('success', 'Pesanan Custom berhasil dikirim! Tunggu konfirmasi admin.');
        }

        return redirect()->back()->with('success', 'Pesanan Custom berhasil dikirim!');
    }
}
