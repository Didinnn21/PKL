<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        Carbon::setLocale('id');
        $today = Carbon::today();

        $todays_earnings = Order::whereDate('created_at', $today)
            ->whereIn('status', ['Selesai', 'Dikirim', 'Diproses'])
            ->sum('total_price');

        $new_orders = Order::whereDate('created_at', $today)->count();
        $total_products = Product::count();
        $total_customers = User::where('role', 'member')->count();

        $chartLabels = [];
        $chartValues = [];
        $dummyTrend = [1500000, 2300000, 1800000, 3500000, 2900000, 4100000, $todays_earnings > 0 ? $todays_earnings : 5000000];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D, d M');
            $chartValues[] = $dummyTrend[6 - $i];
        }

        $chartData = ['labels' => $chartLabels, 'data' => $chartValues];

        $recent_orders = Order::with('user')->latest()->take(5)->get();

        return view('Admin.dashboard', compact(
            'todays_earnings',
            'new_orders',
            'total_products',
            'total_customers',
            'chartData',
            'recent_orders'
        ));
    }

    /**
     * Menampilkan Dashboard untuk Member
     */
    public function member()
    {
        $user_id = Auth::id();

        // 1. STATISTIK UNTUK KARTU (Sesuai Desain Blade Anda)
        $total_orders = Order::where('user_id', $user_id)->count();
        $pending_orders = Order::where('user_id', $user_id)
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Diproses', 'Dikirim'])
            ->count();
        $total_spent = Order::where('user_id', $user_id)
            ->whereNotIn('status', ['Dibatalkan', 'Menunggu Pembayaran'])
            ->sum('total_price');

        // 2. DATA PESANAN TERAKHIR (recent_orders)
        $recent_orders = Order::where('user_id', $user_id)
            ->latest()
            ->take(5)
            ->get();

        // 3. DATA REKOMENDASI PRODUK (products)
        $products = Product::latest()->take(4)->get();

        // Pastikan semua variabel ini dikirim ke view
        return view('Member.dashboard', compact(
            'total_orders',
            'pending_orders',
            'total_spent',
            'recent_orders',
            'products'
        ));
    }
}
