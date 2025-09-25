<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Setting; // Tambahkan ini

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil semua data pengaturan dari database dan ubah menjadi array asosiatif
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // TAMBAHKAN METHOD BARU INI
    public function updateStore(Request $request)
    {
        $validatedData = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_tagline' => 'nullable|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone' => 'nullable|string|max:20',
            'store_email' => 'nullable|email|max:255',
            'payment_info' => 'nullable|string',
            'shipping_info' => 'nullable|string',
        ]);

        // Looping dan simpan setiap pengaturan ke database
        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}
