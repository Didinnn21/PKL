<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua pembeli (member).
     */
    public function index()
    {
        $customers = User::where('role', 'member')
            ->withCount('orders') // Menghitung jumlah pesanan
            ->withSum('orders', 'total_price') // Menjumlahkan total belanja
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }
}
