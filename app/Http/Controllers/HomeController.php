<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::where('persediaan','!=',null)
                            ->where('persediaan_min','!=',null)
                            ->where('persediaan_max','!=',null)
                            ->where('permintaan_min','!=',null)
                            ->where('permintaan_max','!=',null)
                            ->where('produksi_min','!=',null)
                            ->where('produksi_max','!=',null)
                            ->where('foto','!=','noimage-produk.jpg')
                            ->paginate(5);
        return view('home',compact('products'));
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
