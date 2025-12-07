<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('Member.profile.index');
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('Member.profile.edit');
    }
}