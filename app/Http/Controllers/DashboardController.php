<?php

namespace App\Http\Controllers; // INI BAGIAN YANG DIPERBAIKI

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard untuk admin dengan data lengkap.
     */
    public function admin()
    {
        // Data Statistik
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => User::where('role', 'member')->count(),
            'total_revenue' => Order::where('status', 'Completed')->sum('total_price'),
        ];

        // Chart Data (Sales Overview) - Contoh data 8 bulan terakhir
        $salesData = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(7))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $salesLabels = $salesData->map(fn($item) => Carbon::createFromDate($item->year, $item->month)->format('M'));
        $salesValues = $salesData->map(fn($item) => $item->total / 1000000); // dalam jutaan

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];

        // Top Selling Products
        $top_products_data = Order::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->with('product') // Eager load relasi produk
            ->get();

        $top_products = $top_products_data->map(function ($item) {
            return [
                'name' => $item->product->name ?? 'Produk Tidak Ditemukan',
                'sold' => $item->total_sold,
                'revenue' => $item->total_revenue,
                'icon' => 'fa-box', // Ikon default
            ];
        });

        return view('layouts.dashboard.index', compact('stats', 'salesChartData', 'top_products'));
    }

    /**
     * Menampilkan dashboard untuk member dengan data visualisasi.
     */
    public function member()
    {
        $user = Auth::user();

        // 1. Hitung statistik dasar
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->sum('total_price');

        // 2. Siapkan data untuk grafik belanja per bulan (6 bulan terakhir)
        $spendingData = Order::where('user_id', $user->id)
            ->select(
                DB::raw('SUM(total_price) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month") // Format: Jan 2023
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) asc") // Urutkan berdasarkan waktu
            ->get();

        // 3. Format data agar bisa dibaca oleh Chart.js
        $chartLabels = $spendingData->pluck('month');
        $chartValues = $spendingData->pluck('total');

        // 4. Kirim semua data yang sudah dihitung ke view
        return view('Member.dashboard', compact(
            'totalOrders',
            'totalSpent',
            'chartLabels',
            'chartValues'
        ));
    }
}
