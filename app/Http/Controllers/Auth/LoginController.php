<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Mengarahkan pengguna setelah login berdasarkan rolenya.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Jika pengguna yang login adalah admin (is_admin == true atau 1)
        if (Auth::user()->is_admin) {
            return route('admin.dashboard');
        }

        // Jika bukan admin, maka dia adalah member
        return route('member.dashboard');
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
