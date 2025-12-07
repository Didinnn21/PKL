<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan.
     */
    public function index()
    {
        // Mengambil user yang BUKAN admin (role 'member')
        $customers = User::where('role', 'member')->latest()->get();
        return view('Admin.Customers.index', compact('customers'));
    }

    /**
     * Menampilkan form edit pelanggan.
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('Admin.Customers.edit', compact('customer'));
    }

    /**
     * Menyimpan perubahan data pelanggan.
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8', // Password opsional
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika password diisi, update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Menghapus pelanggan.
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        // Cek agar tidak menghapus admin secara tidak sengaja
        if ($customer->role === 'admin') {
            return back()->with('error', 'Anda tidak bisa menghapus akun Admin!');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
