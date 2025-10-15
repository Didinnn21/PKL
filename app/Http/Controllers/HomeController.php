<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product; // PERBAIKAN DI SINI: Tambahkan baris ini
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
        // Logika ini lebih cocok untuk landing page, bukan home setelah login.
        // Sebaiknya, rute '/' diarahkan ke controller lain yang tidak memakai middleware 'auth'
        $products = Product::latest()->get();
        return view('landing.index', compact('products'));
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

    public function showProductDetail($id)
    {
        // Cari produk berdasarkan ID. Jika tidak ditemukan, akan menampilkan halaman 404.
        $product = Product::findOrFail($id);

        // Ambil 3 produk lain secara acak sebagai rekomendasi,
        // pastikan tidak menampilkan produk yang sedang dilihat.
        $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(3)->get();

        // Kembalikan view 'product_detail' dengan data produk dan produk terkait.
        return view('product_detail', compact('product', 'relatedProducts'));
    }
}
