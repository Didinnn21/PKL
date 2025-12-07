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
use App\Http\Controllers\MemberDashboardController; // Import MemberDashboardController
use App\Models\Product; // Ditambahkan untuk mengambil data produk

/*
|--------------------------------------------------------------------------
| Rute Publik (Untuk Pengunjung)
|--------------------------------------------------------------------------
*/

// Menggunakan closure untuk menampilkan landing page dengan beberapa produk
Route::get('/', function () {
    $products = Product::latest()->take(3)->get();
    // Pastikan Anda memiliki view 'home.blade.php' untuk landing page
    return view('home', compact('products'));
})->name('landing');

// Rute detail produk yang bisa diakses publik
Route::get('/product/{product}', function (Product $product) {
    return view('product_detail', compact('product'));
})->name('product.detail');


/*
|--------------------------------------------------------------------------
| Rute Otentikasi (Login, Register, dll.)
|--------------------------------------------------------------------------
*/
Auth::routes();


/*
|--------------------------------------------------------------------------
| Rute Pengalihan Setelah Login
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
| Grup Rute untuk Pengguna Terotentikasi (Admin & Member)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- RUTE KHUSUS ADMIN ---
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::resource('customers', CustomerController::class)->only(['index']);
        Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('settings.index');
        Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/pengaturan/toko', [PengaturanController::class, 'updateStore'])->name('settings.store.update');
    });

    // --- RUTE KHUSUS MEMBER ---
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
        Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');
        Route::resource('orders', MemberOrderController::class)->only(['index', 'show']);

        // Keranjang Belanja
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Halaman Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

        // Rute untuk formulir pesanan kustom
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    });

    // Proses pembuatan pesanan dari checkout (bisa diakses oleh semua yang login)
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    // Rute untuk mengedit profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

});

