<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;

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
        $users = User::orderBy('id','desc')->paginate(5);
        $totalProduk = Product::all()->count();
        $orders = Order::where('keterangan','Diterima')->get();
        $productTerjual = 0;
        foreach ($orders as $order) {
            $productTerjual = $productTerjual + $order->permintaan;
        }

        return view('dashboard', compact('products','users','totalProduk','productTerjual'));
    }
}
