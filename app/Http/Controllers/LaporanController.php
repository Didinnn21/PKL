<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan penjualan dengan data dinamis.
     */
    public function penjualan(Request $request)
    {
        // Data untuk Grafik Pendapatan 6 Bulan Terakhir
        $salesLabels = [];
        $salesValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $salesLabels[] = $date->translatedFormat('F'); // Nama bulan, e.g., Januari
            $salesValues[] = Order::whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)
                                  ->sum('total_price');
        }

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];

        // Data untuk Produk Terlaris
        $top_products = Product::select('products.name', DB::raw('SUM(orders.quantity) as sold'))
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->groupBy('products.name')
            ->orderBy('sold', 'desc')
            ->take(5)
            ->get();

        // Menggunakan view dengan path folder yang sudah diperbaiki
        return view('admin.laporan.penjualan', compact('salesChartData', 'top_products'));
    }
}

