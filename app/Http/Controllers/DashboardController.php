<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Halaman landing page publik.
     */
    public function landing()
    {
        return view('landing');
    }

    /**
     * Menampilkan halaman dashboard utama SETELAH login.
     */
    public function index()
    {
        // 1. DATA PRODUK (DIISI DENGAN PRODUK ASLI DARI KESTORE.ID)
        $top_products = [
            [
                'name' => 'KAOS CUSTOM AESTHETIC',
                'sold' => 1000, // Menggunakan '1RB+' dari screenshot
                'revenue' => 75000 * 1000,
                'icon' => 'fa-tshirt' // Font Awesome icon
            ],
            [
                'name' => 'CREWNECK CUSTOM AESTHETIC',
                'sold' => 108,
                'revenue' => 171000 * 108,
                'icon' => 'fa-tshirt'
            ],
            [
                'name' => 'KAOS PILPRES 2024 COMBAD 24S',
                'sold' => 47,
                'revenue' => 104500 * 47,
                'icon' => 'fa-tshirt'
            ],
            [
                'name' => 'HOODIE CUSTOM AESTHETIC',
                'sold' => 36,
                'revenue' => 185250 * 36,
                'icon' => 'fa-user-secret' // Contoh ikon untuk hoodie
            ],
        ];

        // 2. DATA STATISTIK
        // Kita update 'total_products' berdasarkan kategori dari screenshot
        $stats = [
            'total_products' => 12, // Dari screenshot kategori "Produk (12)"
            'total_orders' => 85, // Data ini masih dummy
            'total_customers' => 234, // Data ini masih dummy
            'total_revenue' => 45000000, // Data ini masih dummy
        ];

        // 3. DATA AKTIVITAS TERBARU (Masih menggunakan data dummy)
        $recent_activities = [
            ['type' => 'order', 'message' => 'Pesanan baru #1234 diterima', 'time' => '15 menit lalu'],
            ['type' => 'product', 'message' => 'Produk "KAOS CUSTOM" diupdate', 'time' => '1 jam lalu'],
            ['type' => 'customer', 'message' => 'Pengguna Budi mendaftar', 'time' => '3 jam lalu'],
        ];

        // 4. KIRIM SEMUA DATA KE VIEW
        return view('dashboard.index', [
            'stats' => $stats,
            'recent_activities' => $recent_activities,
            'top_products' => $top_products,
        ]);
    }
}
