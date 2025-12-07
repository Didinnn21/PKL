<?php

namespace App\Http\Controllers;

use App\Models\ShippingService;
use Illuminate\Http\Request;

class AdminShippingController extends Controller
{
    public function index()
    {
        $shippings = ShippingService::all();
        return view('Admin.Shippings.index', compact('shippings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'etd' => 'nullable|string',
        ]);

        ShippingService::create($request->all());

        return redirect()->route('admin.shippings.index')->with('success', 'Jasa kirim berhasil ditambahkan');
    }

    public function destroy($id)
    {
        ShippingService::findOrFail($id)->delete();
        return redirect()->route('admin.shippings.index')->with('success', 'Jasa kirim dihapus');
    }
}
