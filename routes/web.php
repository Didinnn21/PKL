<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as AdminProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\MemberOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MemberProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Rute Publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $products = Product::latest()->take(3)->get();
    return view('home', compact('products'));
})->name('landing');

Route::get('/product/{product}', function (Product $product) {
    return view('product_detail', compact('product'));
})->name('product.detail');

Auth::routes();

/*
|--------------------------------------------------------------------------
| Rute Redirect Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('member.dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rute Terotentikasi
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- RUTE ADMIN ---
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::resource('customers', CustomerController::class);
        Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('settings.index');
        Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/pengaturan/toko', [PengaturanController::class, 'updateStore'])->name('settings.store.update');
    });

    // --- RUTE MEMBER ---
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
        Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');
        Route::resource('orders', MemberOrderController::class)->only(['index', 'show']);

        // Keranjang & Checkout
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

        // --- Custom Order Member ---
        // (Route ini yang sebelumnya hilang dan bikin error)
        Route::get('/custom-order', [OrderController::class, 'createCustom'])->name('custom.create');
    });

    // --- RUTE ORDER (Bisa diakses Admin & Member) ---

    // 1. Route untuk Checkout dari Keranjang
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    // 2. Route untuk Proses Simpan Custom Order (POST)
    Route::post('/custom-order', [OrderController::class, 'storeCustom'])->name('custom.order');

    // --- Rute Profil ---
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});
