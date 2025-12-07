<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('Member.profile.index');
    }

    public function edit()
    {
        return view('Member.profile.edit');
    }

    /**
     * Method untuk menyimpan perubahan profil
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
