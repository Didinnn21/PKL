<?php

namespace App\Http\Controllers;

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

        // Chart Data (Sales Overview)
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
        $salesValues = $salesData->map(fn($item) => ($item->total) ? $item->total / 1000000 : 0); // dalam jutaan

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
            ->with('product')
            ->get();

        $top_products = $top_products_data->map(function ($item) {
            return [
                'name' => $item->product->name ?? 'Produk Tidak Ditemukan',
                'sold' => $item->total_sold,
                'revenue' => $item->total_revenue,
                'icon' => 'fa-box',
            ];
        });

        return view('layouts.dashboard.index', compact('stats', 'salesChartData', 'top_products'));
    }

    /**
     * PERBAIKAN: Menampilkan dashboard untuk member dengan data visualisasi yang lebih kaya.
     */
    public function member()
    {
        $user = Auth::user();

        // 1. Hitung statistik dasar untuk kartu
        $totalPesanan = Order::where('user_id', $user->id)->count();
        $pesananAktif = Order::where('user_id', $user->id)->whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        $pesananSelesai = Order::where('user_id', $user->id)->where('status', 'Selesai')->count();

        // 2. Ambil 5 pesanan terbaru untuk tabel ringkasan
        $orders = Order::where('user_id', $user->id)->with('product')->latest()->take(5)->get();

        // 3. Siapkan data untuk grafik donat status pesanan
        $orderStatusData = Order::where('user_id', $user->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // 4. Kirim semua data yang sudah dihitung ke view
        return view('Member.dashboard', compact(
            'totalPesanan',
            'pesananAktif',
            'pesananSelesai',
            'orders',
            'orderStatusData'
        ));
    }
}
