<?php

namespace App\Http\Controllers; // <- Namespace utama

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua pembeli (member).
     */
    public function index()
    {
        $customers = User::where('role', 'member')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }
}
