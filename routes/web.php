<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\MemberOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MemberProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam sebuah grup yang berisi
| middleware "web".
|
*/

// =====================================================================
// --- RUTE PUBLIK (Dapat diakses tanpa login) ---
// =====================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');

// Rute Otentikasi bawaan Laravel (Login, Register, dll.)
Auth::routes();


// =====================================================================
// --- GRUP RUTE UNTUK PENGGUNA TERAUTENTIKASI (MEMBER) ---
// =====================================================================
Route::middleware(['auth'])->group(function () {

    // Rute untuk proses pemesanan oleh member
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    // Semua rute di bawah ini memiliki prefix 'member' dan nama 'member.'
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');
        Route::resource('orders', MemberOrderController::class)->only(['index', 'show']);
    });
});


// =====================================================================
// --- GRUP RUTE KHUSUS ADMIN ---
// =====================================================================
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
    Route::put('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('customers', CustomerController::class)->only(['index']);
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('settings.index');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/pengaturan/toko', [PengaturanController::class, 'updateStore'])->name('settings.store.update');
});
