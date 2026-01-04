<?php

namespace App\Http\Controllers;

use App\Models\ShippingService;
use Illuminate\Http\Request;

class AdminShippingController extends Controller
{
    /**
     * Menampilkan daftar jasa kirim
     */
    public function index()
    {
        // Ambil data terbaru (latest) agar yang baru diinput muncul di atas
        $shippings = ShippingService::latest()->get();
        return view('Admin.Shippings.index', compact('shippings'));
    }

    /**
     * Menyimpan jasa kirim baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'etd' => 'nullable|string|max:50',
        ]);

        ShippingService::create($request->all());

        return redirect()->route('admin.shippings.index')->with('success', 'Jasa kirim berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit (TAMBAHAN BARU)
     */
    public function edit($id)
    {
        // Cari data berdasarkan ID, jika tidak ada tampilkan 404
        $shipping = ShippingService::findOrFail($id);

        // Tampilkan view edit
        return view('Admin.Shippings.edit', compact('shipping'));
    }

    /**
     * Mengupdate data ke database (TAMBAHAN BARU)
     */
    public function update(Request $request, $id)
    {
        // Validasi input (sama dengan store)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'etd' => 'nullable|string|max:50',
        ]);

        // Cari data dan update
        $shipping = ShippingService::findOrFail($id);
        $shipping->update($request->all());

        return redirect()->route('admin.shippings.index')->with('success', 'Jasa kirim berhasil diperbarui!');
    }

    /**
     * Menghapus jasa kirim
     */
    public function destroy($id)
    {
        $shipping = ShippingService::findOrFail($id);
        $shipping->delete();

        return redirect()->route('admin.shippings.index')->with('success', 'Jasa kirim berhasil dihapus.');
    }
}
