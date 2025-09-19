<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('member.dashboard');
    }

    public function admin(Request $request)
    {
        $filter = $request->query('filter', 'weekly'); // Default filter adalah mingguan
        $salesLabels = [];
        $salesValues = [];

        switch ($filter) {
            case 'yearly':
                // Data 12 bulan terakhir
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $salesLabels[] = $date->translatedFormat('F'); // Nama bulan, e.g., Januari
                    $salesValues[] = rand(20000000, 50000000); // Simulasi data bulanan
                }
                break;

            case 'monthly':
                // Data 30 hari terakhir
                for ($i = 29; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $salesLabels[] = $date->format('d M'); // Tanggal & bulan, e.g., 20 Sep
                    $salesValues[] = rand(500000, 2500000); // Simulasi data harian
                }
                break;

            default: // weekly
                // Data 7 hari terakhir
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $salesLabels[] = $date->translatedFormat('l'); // Nama hari, e.g., Senin
                    $salesValues[] = rand(500000, 2000000);
                }
                break;
        }

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];

        $stats = [
            'pendapatan_hari_ini' => end($salesValues),
            'pesanan_baru' => 15,
            'pelanggan_baru' => 8,
            'total_produk' => 54,
        ];

        $pesanan_terbaru = [
            ['id' => 'KESTORE-001', 'pelanggan' => 'Andi Budianto', 'total' => 150000, 'status' => 'Sedang Diproses'],
            ['id' => 'KESTORE-002', 'pelanggan' => 'Citra Lestari', 'total' => 275000, 'status' => 'Menunggu Pembayaran'],
        ];

        return view('Admin.dashboard', compact('stats', 'pesanan_terbaru', 'salesChartData', 'filter'));
    }

    public function member()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->latest()->paginate(10);
        return view('Member.dashboard', compact('orders'));
    }
}
