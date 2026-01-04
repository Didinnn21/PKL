<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon; // Wajib di-import

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Atur Schema String (Mencegah error migrasi pada versi MySQL lama)
        Schema::defaultStringLength(191);

        // 2. Atur Pagination menggunakan Bootstrap 5
        Paginator::useBootstrapFive();

        // 3. ATUR BAHASA INDONESIA & ZONA WAKTU (PENTING!)
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
