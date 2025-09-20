<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController as MemberOrderController;

// TAMBAHKAN CONTROLLER BARU UNTUK ADMIN
use App\Http\Controllers\OrderController as AdminOrderController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Artisan;


Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/product/{product}', [MemberOrderController::class, 'show'])->name('product.detail');


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/order', [MemberOrderController::class, 'store'])->name('order.store');
});


Route::middleware(['auth', 'is_admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('products', ProductController::class);

    // RUTE BARU: PESANAN & PEMBELI
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');

    Route::prefix('laporan')->as('laporan.')->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
    });
});


Route::middleware(['auth'])->prefix('member')->as('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->back()->with('success', 'Cache cleared successfully!');
})->name('clear-cache')->middleware(['auth', 'is_admin']);
