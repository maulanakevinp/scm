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
        $orders = Order::where('keterangan','Diterima')->orderBy('id','desc')->get();
        $productTerjual = 0;
        $tahun = array();
        $bulan = array();
        foreach ($orders as $order) {
            $productTerjual = $productTerjual + $order->permintaan;
            if (!in_array(date_format($order->updated_at, "Y"),$tahun)) {
                array_push($tahun,date_format($order->updated_at, "Y"));
            }
            if(!array_key_exists(date_format($order->updated_at,"m"),$bulan)){
                $bulan[date_format($order->updated_at,"m")] = date_format($order->updated_at,"F");
            }
        }
        return view('dashboard', compact('products','users','totalProduk','productTerjual','tahun','orders','bulan'));
    }
}
