<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function penjualan(Request $request)
    {
       
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        $salesData = Order::query()
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total'))
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')->orderBy('year', 'asc')->orderBy('month', 'asc')
            ->get()->keyBy(fn($item) => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT));

        $salesLabels = [];
        $salesValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $salesLabels[] = $date->translatedFormat('F');
            $salesValues[] = ($salesData->get($key)->total ?? 0) / 1000000;
        }
        $salesChartData = ['labels' => $salesLabels, 'data' => $salesValues];

        $top_products = Product::select('products.name', DB::raw('SUM(orders.quantity) as sold'))
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->groupBy('products.name')->orderBy('sold', 'desc')->take(5)->get();

        return view('admin.laporan.penjualan', compact('salesChartData', 'top_products'));
    }
}
