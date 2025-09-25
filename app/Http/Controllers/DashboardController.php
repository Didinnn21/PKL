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

    public function member()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->latest()->paginate(10);
        return view('Member.dashboard', compact('orders'));
    }
}
