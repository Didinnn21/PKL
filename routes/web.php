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
*/

// --- RUTE PUBLIK ---
// PERBAIKAN: Mengganti nama rute menjadi 'landing'
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/product/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');

// --- RUTE OTENTIKASI ---
Auth::routes();

// --- RUTE REDIRECT SETELAH LOGIN ---
Route::get('/redirect', [App\Http\Controllers\RedirectController::class, 'cek']);

// =====================================================================
// --- GRUP RUTE KHUSUS ADMIN ---
// =====================================================================
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
});


// =====================================================================
// --- GRUP RUTE KHUSUS MEMBER ---
// =====================================================================
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'memberDashboard'])->name('dashboard');
    Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');
    Route::resource('orders', MemberOrderController::class);
});

// Rute untuk proses pemesanan oleh member
Route::post('/order', [OrderController::class, 'store'])->name('order.store')->middleware('auth');
