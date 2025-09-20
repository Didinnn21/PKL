<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController; // Pastikan ini ada
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| 1. Rute Publik (Storefront)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/product/{product}', [OrderController::class, 'show'])->name('product.detail');

/*
|--------------------------------------------------------------------------
| 2. Rute Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| 3. Rute Dashboard & Pemesanan (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});

/*
|--------------------------------------------------------------------------
| 4. Rute Spesifik Admin (Wajib Login & Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Rute untuk mengelola produk
    Route::resource('products', ProductController::class);
});

/*
|--------------------------------------------------------------------------
| 5. Rute Spesifik Member (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('member')->as('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
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
