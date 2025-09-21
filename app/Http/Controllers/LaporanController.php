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
        // === OPTIMASI QUERY GRAFIK PENJUALAN (1 Query) ===
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

        $salesData = Order::query()
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy(function ($item) {
                // Buat kunci unik untuk setiap bulan, contoh: "2025-09"
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        $salesLabels = [];
        $salesValues = [];
        // Loop 6 kali untuk mempersiapkan label bulan
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $salesLabels[] = $date->translatedFormat('F');
            // Ambil data dari koleksi yang sudah kita query, jika tidak ada, beri nilai 0
            $salesValues[] = ($salesData->get($key)->total ?? 0) / 1000000; // Dalam Juta
        }
        // =======================================================

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];

        // Data untuk Produk Terlaris (Query ini sudah efisien)
        $top_products = Product::select('products.name', DB::raw('SUM(orders.quantity) as sold'))
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->groupBy('products.name')
            ->orderBy('sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.laporan.penjualan', compact('salesChartData', 'top_products'));
    }
}
