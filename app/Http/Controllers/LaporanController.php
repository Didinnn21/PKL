<?php

namespace App\Http\Controllers; // <- Namespace utama

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan penjualan.
     */
    public function penjualan(Request $request)
    {
        $salesLabels = [];
        $salesValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $salesLabels[] = $date->translatedFormat('F');
            $salesValues[] = rand(20, 50);
        }

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];

        $top_products = [
            ['name' => 'Kestore Hoodie Basic', 'sold' => 150, 'revenue' => 37500000],
            ['name' => 'Kestore T-shirt Logo', 'sold' => 120, 'revenue' => 14400000],
            ['name' => 'Kestore Totebag Canvas', 'sold' => 95, 'revenue' => 7125000],
        ];

        return view('admin.laporan.penjualan', compact('salesChartData', 'top_products'));
    }
}
