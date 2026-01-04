<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User; // Tambahkan Model User
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function penjualan(Request $request)
    {
        // --- 1. DATA DUMMY GRAFIK (PENDAPATAN) ---
        $dummySales = [
            500000,
            1500000,
            1000000,
            2500000,
            2000000,
            3500000,
            3000000,
            4500000,
            4000000,
            5500000,
            5000000,
            6500000
        ];

        // --- 2. DATA DUMMY PRODUK TERLARIS ---
        $dummyProducts = collect([
            (object)['name' => 'Hoodie Signature Black', 'sold' => 156],
            (object)['name' => 'T-Shirt Oversized White', 'sold' => 142],
            (object)['name' => 'Jaket Varsity Kestore', 'sold' => 98],
            (object)['name' => 'Crewneck Basic Navy', 'sold' => 75],
            (object)['name' => 'Kaos Polos Premium', 'sold' => 45],
        ]);

        // --- 3. DATA DUMMY PELANGGAN TERBANYAK (BARU) ---
        $dummyCustomers = collect([
            (object)['name' => 'Sultan Andara', 'email' => 'raffi@gmail.com', 'total' => 15500000, 'transactions' => 12],
            (object)['name' => 'Juragan 99', 'email' => 'juragan@mslow.com', 'total' => 12400000, 'transactions' => 8],
            (object)['name' => 'Crazy Rich PIK', 'email' => 'pik@rich.com', 'total' => 9800000, 'transactions' => 5],
            (object)['name' => 'Siswi SMAN 1', 'email' => 'siswi@sekolah.id', 'total' => 5400000, 'transactions' => 15],
            (object)['name' => 'Anak Senja', 'email' => 'kopi@senja.com', 'total' => 2100000, 'transactions' => 3],
        ]);

        // --- LOGIKA LOOP GRAFIK ---
        $salesLabels = [];
        $salesValues = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $salesLabels[] = $date->translatedFormat('M Y');
            $index = 11 - $i;
            $salesValues[] = $dummySales[$index] ?? 0;
        }
        $salesChartData = ['labels' => $salesLabels, 'data' => $salesValues];

        // Assign Data Dummy ke Variable View
        $top_products = $dummyProducts;
        $top_customers = $dummyCustomers;

        /* --- KODE ASLI (JIKA INGIN PAKAI DATABASE NANTI) ---

           // 1. Top Customers Query
           $top_customers = Order::select('users.name', 'users.email', DB::raw('SUM(orders.total_price) as total'), DB::raw('COUNT(orders.id) as transactions'))
               ->join('users', 'orders.user_id', '=', 'users.id')
               ->whereIn('orders.status', ['Selesai', 'Dikirim', 'Diproses'])
               ->groupBy('users.id', 'users.name', 'users.email')
               ->orderBy('total', 'desc')
               ->take(5)
               ->get();
        */

        return view('Admin.laporan.penjualan', compact('salesChartData', 'top_products', 'top_customers'));
    }
}
