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

// Rute Landing Page
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/product/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');

// Rute Otentikasi
Auth::routes();

// Rute Redirect setelah Login
Route::get('/redirect', function() {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('member.dashboard');
})->middleware('auth')->name('dashboard');


// =====================================================================
// --- GRUP RUTE KHUSUS ADMIN ---
// =====================================================================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('settings.index');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('settings.index');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/pengaturan/toko', [PengaturanController::class, 'updateStore'])->name('settings.store.update');
});


// =====================================================================
// --- GRUP RUTE KHUSUS MEMBER ---
// =====================================================================
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
    Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');
    Route::resource('orders', MemberOrderController::class);
});

// Rute untuk proses pemesanan oleh member
Route::post('/order', [OrderController::class, 'store'])->name('order.store')->middleware('auth');
