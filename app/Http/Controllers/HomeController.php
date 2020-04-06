<?php

namespace App\Http\Controllers;

use App\Product;

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
        $products = Product::orderBy('id','desc')->paginate(5);
        $totalProduk = Product::all()->count();
        return view('dashboard', compact('products','totalProduk'));
    }
}
