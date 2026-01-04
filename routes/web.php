<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

// --- IMPORT CONTROLLERS ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController as AdminProductController;
use App\Http\Controllers\MemberProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminShippingController;
use App\Http\Controllers\MemberOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK
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
| 2. RUTE REDIRECT DASHBOARD
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
| 3. RUTE TEROTENTIKASI (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ==========================================
    // A. RUTE ADMIN (Middleware: is_admin)
    // ==========================================
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::resource('customers', CustomerController::class);
        Route::resource('shippings', AdminShippingController::class)->except(['create', 'show']);
        Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');

        // Pengaturan Toko
        Route::get('/Setings', [PengaturanController::class, 'index'])->name('settings.index');
        Route::put('/Setings/profil', [PengaturanController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/Setings/toko', [PengaturanController::class, 'updateStore'])->name('settings.store.update');
        Route::put('/Setings/pembayaran', [PengaturanController::class, 'updatePayment'])->name('settings.payment.update');
    });

    // ==========================================
    // B. RUTE MEMBER (Pelanggan)
    // ==========================================
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'member'])->name('dashboard');
        Route::get('/products', [MemberProductController::class, 'index'])->name('products.index');

        // Mengaktifkan rute resource penuh untuk pesanan
        Route::resource('orders', MemberOrderController::class);

        // Pembayaran
        Route::get('/orders/{order}/payment', [MemberOrderController::class, 'payment'])->name('orders.payment');
        Route::put('/orders/{order}/payment', [MemberOrderController::class, 'updatePayment'])->name('orders.update_payment');

        // PERBAIKAN: Resource Orders mencakup edit, update, dan destroy
        Route::resource('orders', MemberOrderController::class);

        // Pembayaran
        Route::get('/orders/{order}/payment', [MemberOrderController::class, 'payment'])->name('orders.payment');
        Route::put('/orders/{order}/payment', [MemberOrderController::class, 'updatePayment'])->name('orders.update_payment');

        // Keranjang Belanja
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Checkout & Order
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
        Route::post('/order', [OrderController::class, 'store'])->name('order.store');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/member/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('member.checkout.direct');
        // Di dalam group middleware auth member:
        Route::match(['get', 'post'], '/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('member.checkout.direct');

        // Custom Order
        Route::get('/custom-order', [OrderController::class, 'createCustom'])->name('custom.create');
        Route::post('/custom-order', [OrderController::class, 'storeCustom'])->name('custom.order');
    });

    // ==========================================
    // C. RUTE PROFIL USER
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
