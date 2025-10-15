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
// CONTROLLER BARU
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Rute Landing Page
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/product/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');

// Rute Otentikasi
Auth::routes();

// Rute Redirect setelah Login
Route::get('/redirect', function () {
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
    // Tambahkan rute untuk update store settings
    Route::put('/pengaturan/toko', [PengaturanController::class, 'updateStore'])->name('settings.store.update');
});


// =====================================================================
// --- GRUP RUTE KHUSUS MEMBER (TERMASUK KERANJANG & CHECKOUT) ---
// =====================================================================
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
    Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');
    Route::resource('orders', MemberOrderController::class);

    // RUTE BARU: Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // RUTE BARU: Halaman Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});

// Rute untuk proses checkout (menyimpan order dari keranjang)
Route::post('/order', [OrderController::class, 'store'])->name('order.store')->middleware('auth');
