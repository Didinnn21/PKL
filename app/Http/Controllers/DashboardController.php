<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class DashboardController extends Controller
{
    /**
     * Method ini akan menjadi "gerbang" setelah login.
     * Ia akan memeriksa peran pengguna dan mengarahkan ke dashboard yang sesuai.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('member.dashboard');
    }

    /**
     * Menampilkan dashboard untuk Admin dengan data lengkap.
     */
    public function admin()
    {
        // --- LOGIKA BARU UNTUK GRAFIK PENJUALAN ---
        $salesChartData = [];
        $salesLabels = [];
        $salesValues = [];

        // Loop untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesLabels[] = $date->translatedFormat('l'); // Format hari (e.g., Senin)

            // NANTINYA, GANTI INI DENGAN QUERY ASLI KE DATABASE ANDA
            // Contoh query asli:
            // $dailySale = Order::whereDate('created_at', $date)->sum('total_price');
            // $salesValues[] = $dailySale;

            // Untuk saat ini, kita gunakan angka acak sebagai simulasi
            $salesValues[] = rand(500000, 2000000);
        }

        $salesChartData = [
            'labels' => $salesLabels,
            'data' => $salesValues,
        ];
        // --- AKHIR LOGIKA GRAFIK ---

        // Data dummy untuk kartu statistik
        $stats = [
            'pendapatan_hari_ini' => end($salesValues), // Ambil data penjualan terakhir sebagai pendapatan hari ini
            'pesanan_baru' => 15,
            'pelanggan_baru' => 8,
            'total_produk' => 54,
        ];

        // Data dummy untuk tabel pesanan terbaru
        $pesanan_terbaru = [
            ['id' => 'KESTORE-001', 'pelanggan' => 'Andi Budianto', 'total' => 150000, 'status' => 'Sedang Diproses'],
            ['id' => 'KESTORE-002', 'pelanggan' => 'Citra Lestari', 'total' => 275000, 'status' => 'Menunggu Pembayaran'],
            ['id' => 'KESTORE-003', 'pelanggan' => 'Doni Saputra', 'total' => 85000, 'status' => 'Telah Dikirim'],
            ['id' => 'KESTORE-004', 'pelanggan' => 'Eka Wulandari', 'total' => 320000, 'status' => 'Selesai'],
        ];

        return view('Admin.dashboard', compact('stats', 'pesanan_terbaru', 'salesChartData'));
    }

    /**
     * Menampilkan dashboard untuk Member.
     */
    public function member()
    {
        return view('Member.dashboard');
    }
}
