<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'member')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->latest()
            ->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }
}
