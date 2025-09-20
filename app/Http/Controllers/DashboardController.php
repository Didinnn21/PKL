<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product; // Tambahkan ini
use App\Models\User;    // Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('member.dashboard');
    }

    public function admin(Request $request)
    {
        // === PENGAMBILAN DATA DINAMIS DARI DATABASE ===
        $stats = [
            'pendapatan_hari_ini' => Order::whereDate('created_at', Carbon::today())->sum('total_price'),
            'pesanan_baru' => Order::where('status', 'Menunggu Pembayaran')->count(),
            'pelanggan_baru' => User::where('role', 'member')->whereDate('created_at', Carbon::today())->count(),
            'total_produk' => Product::count(),
        ];

        $pesanan_terbaru = Order::with('user')->latest()->take(5)->get();
        // ===============================================

        // Logika Chart (bisa dibiarkan dulu, sudah dinamis)
        $filter = $request->query('filter', 'weekly');
        $salesLabels = [];
        $salesValues = [];

        switch ($filter) {
            case 'yearly':
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $salesLabels[] = $date->translatedFormat('F');
                    $salesValues[] = Order::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->sum('total_price');
                }
                break;
            case 'monthly':
                for ($i = 29; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $salesLabels[] = $date->format('d M');
                    $salesValues[] = Order::whereDate('created_at', $date)->sum('total_price');
                }
                break;
            default: // weekly
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $salesLabels[] = $date->translatedFormat('l');
                    $salesValues[] = Order::whereDate('created_at', $date)->sum('total_price');
                }
                break;
        }

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];

        return view('Admin.dashboard', compact('stats', 'pesanan_terbaru', 'salesChartData', 'filter'));
    }

    public function member()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->latest()->paginate(10);
        return view('Member.dashboard', compact('orders'));
    }
}
