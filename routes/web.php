<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Controller untuk halaman publik, autentikasi, & member
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberOrderController; 

// Controller yang digunakan khusus untuk Admin
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;

/* Rute Publik */

Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/product/{product}', [OrderController::class, 'show'])->name('product.detail');

/* Rute Autentikasi */
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

/* Rute Umum Pengguna Terautentikasi */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});

/* Rute Spesifik Admin */
Route::middleware(['auth', 'is_admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('settings', [PengaturanController::class, 'index'])->name('settings.index');
    Route::put('settings/profile', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
});

/* Rute Spesifik Member */
Route::middleware(['auth'])->prefix('member')->as('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
    // RUTE BARU UNTUK PESANAN MEMBER
    Route::get('/orders', [MemberOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [MemberOrderController::class, 'show'])->name('orders.show');
});

/* Rute Utilitas */
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache cleared successfully!');
})->name('clear-cache')->middleware(['auth', 'is_admin']);
