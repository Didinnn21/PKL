<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function memberDashboard(Request $request)
    {
        $user = Auth::user();

        // Ambil semua pesanan dari pengguna yang sedang login
        $orders = Order::where('user_id', $user->id);

        // 1. Hitung statistik dasar
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total_price');

        // 2. Siapkan data untuk grafik belanja per bulan (6 bulan terakhir)
        $spendingData = Order::where('user_id', $user->id)
            ->select(
                DB::raw('SUM(total_price) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month") // Format bulan menjadi 'Jan 2023', etc.
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) asc") // Urutkan berdasarkan tanggal
            ->get();

        // Format data untuk Chart.js
        $chartLabels = $spendingData->pluck('month');
        $chartValues = $spendingData->pluck('total');

        // Kirim semua data ke view
        return view('Member.dashboard', compact(
            'totalOrders',
            'totalSpent',
            'chartLabels',
            'chartValues'
        ));
    }
}
