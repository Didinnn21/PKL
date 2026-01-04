<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Setting;

class PengaturanController extends Controller
{
    public function index()
    {
        // Mengambil semua data pengaturan menjadi array ['key' => 'value']
        // Contoh akses: $settings['store_name']
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('Admin.Setings.index', compact('settings'));
    }

    /**
     * Update Profil Admin (User Table)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update Informasi Toko (Settings Table)
     */
    public function updateStore(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_phone' => 'nullable|string|max:20',
            'store_address' => 'nullable|string',
        ]);

        // Simpan ke database (Looping key-value)
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Informasi toko berhasil diperbarui!');
    }

    /**
     * Update Rekening Pembayaran (Settings Table)
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'payment_bank_name' => 'required|string',
            'payment_account_number' => 'required|numeric',
            'payment_account_holder' => 'required|string',
        ]);

        // Data yang akan disimpan dengan key khusus
        $paymentData = [
            'payment_bank_name' => $request->payment_bank_name,
            'payment_account_number' => $request->payment_account_number,
            'payment_account_holder' => $request->payment_account_holder,
        ];

        foreach ($paymentData as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Rekening pembayaran berhasil disimpan.');
    }
}
