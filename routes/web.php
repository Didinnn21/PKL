<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\MemberOrderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\MemberProductController; // Jangan lupa import controller baru

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk Landing Page (Publik)
Route::get('/', [HomeController::class, 'index'])->name('landing.index');
Route::get('/product/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');

// Rute Otentikasi (Login, Register, dll.)
Auth::routes();

// Rute Redirect setelah Login
Route::get('/redirect', [RedirectController::class, 'cek']);

// Rute untuk Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk mengelola produk (Admin)
    Route::resource('products', ProductController::class);

    // Rute untuk mengelola pesanan (Admin)
    Route::resource('orders', AdminOrderController::class);

    // Rute untuk mengelola pelanggan (Admin)
    Route::resource('customers', CustomerController::class);

    // Rute Laporan
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');

    // Rute Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
});

// Rute untuk Member yang sudah login
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'memberDashboard'])->name('dashboard');

    // ===============================================================
    // == RUTE BARU UNTUK HALAMAN PRODUK KHUSUS MEMBER ==
    // ===============================================================
    Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');

    // Rute untuk mengelola pesanan (Member)
    Route::resource('orders', MemberOrderController::class);
});

// Fallback jika user mencoba akses /home, arahkan sesuai role
Route::get('/home', [HomeController::class, 'index']);
