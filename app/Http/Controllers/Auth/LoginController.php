<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // <-- Pastikan baris ini ada

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani otentikasi pengguna untuk aplikasi dan
    | mengarahkan mereka ke layar utama Anda. Controller menggunakan sebuah trait
    | untuk menyediakan fungsionalitasnya dengan mudah ke aplikasi Anda.
    |
    */

    use AuthenticatesUsers;

    /**
     * Ke mana pengguna akan diarahkan setelah login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME; // Baris ini tidak kita gunakan, kita ganti dengan method di bawah.

    /**
     * FUNGSI BARU DITAMBAHKAN
     * Method ini akan dipanggil secara otomatis setelah pengguna berhasil login.
     * Ia akan memeriksa role pengguna dan mengarahkannya ke dashboard yang sesuai.
     */
    public function redirectTo()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return route('admin.dashboard'); // Arahkan ke dashboard admin
                break;
            case 'member':
                return route('member.dashboard'); // Arahkan ke dashboard member
                break;
            default:
                return '/'; // Arahkan ke halaman utama jika role tidak dikenali
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
