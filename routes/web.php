<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController; // Pastikan ini ada
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| 1. Rute Publik (Storefront) - Akses tanpa login
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| 2. Rute Autentikasi (Didefinisikan Manual untuk Menghindari Error)
|--------------------------------------------------------------------------
*/

// Rute untuk pengguna yang belum login (guest)
Route::middleware('guest')->group(function () {
    // Registrasi
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Rute untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| 3. Rute Dashboard Universal (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| 4. Rute Spesifik Admin (Wajib Login & Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    // Tambahkan rute-rute admin lainnya di sini
});

/*
|--------------------------------------------------------------------------
| 5. Rute Spesifik Member (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('member')->as('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
    // Tambahkan rute-rute member lainnya di sini
});

/*
|--------------------------------------------------------------------------
| 6. Rute Utilitas (Opsional)
|--------------------------------------------------------------------------
*/
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return redirect()->back()->with('success', 'Cache cleared successfully!');
})->name('clear-cache')->middleware(['auth', 'is_admin']);
