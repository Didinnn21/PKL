<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MemberOrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('Member.orders.index', compact('orders'));
    }


    public function show(Order $order)
    {
        
        if ($order->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $order->load('product');
        return view('Member.orders.show', compact('order'));
    }
}
