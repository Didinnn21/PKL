<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Menangani permintaan yang masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan pengguna sudah terautentikasi (Login)
        // 2. Pastikan pengguna memiliki kolom 'role' dengan nilai 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika validasi gagal (bukan admin), pengguna diarahkan kembali
        // ke dashboard member dengan pesan peringatan.
        return redirect()->route('member.dashboard')
            ->with('error', 'Akses Ditolak! Anda tidak memiliki otoritas sebagai Administrator.');
    }
}
