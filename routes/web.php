<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| 1. Rute Publik (Storefront) - Akses tanpa login
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/products', [HomeController::class, 'products'])->name('products.all');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| 2. Autentikasi (Login, Register, Logout)
|--------------------------------------------------------------------------
*/
// Auth::routes(); → jangan pakai default, karena kita sudah override AuthenticatedSessionController
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| 3. Rute Transaksional (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [HomeController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [HomeController::class, 'viewCart'])->name('cart.view');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
});

/*
|--------------------------------------------------------------------------
| 4. Dashboard
|--------------------------------------------------------------------------
*/

// == DASHBOARD ADMIN ==
Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('dashboard.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin');

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', fn() => view('dashboard.products.index'))->name('index');
        Route::get('/create', fn() => view('dashboard.products.create'))->name('create');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', fn() => view('dashboard.orders.index'))->name('index');
    });

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', fn() => view('dashboard.customers.index'))->name('index');
    });
});

// == DASHBOARD MEMBER ==
Route::prefix('member')->middleware(['auth'])->name('dashboard.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('member');
});

/*
|--------------------------------------------------------------------------
| 5. Rute Utilitas (Opsional)
|--------------------------------------------------------------------------
*/
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return redirect()->back()->with('success', 'Cache cleared successfully!');
})->name('clear-cache')->middleware(['auth', 'is_admin']);
