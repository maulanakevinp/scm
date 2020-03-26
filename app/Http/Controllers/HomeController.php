<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function kebijakanPrivasi()
    {
        return view('auth.policy');
    }

    public function dashboard()
    {
        # code...
    }
}
