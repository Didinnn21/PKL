<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    
    public function index()
    {

        $orders = Order::where('user_id', Auth::id())->with('product')->latest()->get();
        return view('member.orders.index', compact('orders'));
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'design_file' => 'nullable|file|mimes:jpg,png,jpeg,cdr,ai,psd|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;
        $designFilePath = null;
        if ($request->hasFile('design_file')) {
            $designFilePath = $request->file('design_file')->store('designs', 'public');
        }


        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'Pending',
            'notes' => $request->notes,
            'design_file' => $designFilePath,
        ]);

        return redirect()->route('member.dashboard')->with('success', 'Pesanan berhasil dibuat.');
    }


    public function show(Order $order)
    {

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('member.orders.show', compact('order'));
    }


    public function edit(Order $order)
    {

    }


    public function update(Request $request, Order $order)
    {

    }


    public function destroy(Order $order)
    {
        // Pastikan member hanya bisa menghapus order miliknya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file desain dari storage jika ada
        if ($order->design_file) {
            Storage::disk('public')->delete($order->design_file);
        }

        $order->delete();

        return redirect()->route('member.dashboard')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
