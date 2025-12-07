<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    /**
     * Display the member dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('Member.dashboard');
    }
}