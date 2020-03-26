<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Rules\Antara;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('orders.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'permintaan' => ['required', new Antara($product->permintaan_min, $product->permintaan_max)]
        ]);

        $data['produksi'] = $this->produksi($request, $product);
        $data['keterangan'] = 'Belum di setujui';
        $data['product_id'] = $product->id;

        $order = Order::create($data);
        return redirect(route('order.show',$order))->with('success','Pesanan berhasil terkirim');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'permintaan' => ['required', new Antara($order->product->permintaan_min, $order->product->permintaan_max)]
        ]);

        $data['produksi'] = $this->produksi($request, $order->product);

        $order = Order::create($data);
        return redirect(route('order.show',$order))->with('success','Pesanan berhasil terkirim');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        Product::destroy($order->id);
        return redirect('/order')->with('success','Pesanan berhasil dihapus');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function belanja()
    {
        $products = Product::where('persediaan','!=',null)
                            ->where('foto','!=','public/noimage-produk.jpg')
                            ->where('persediaan_min','!=',null)
                            ->where('persediaan_max','!=',null)
                            ->where('permintaan_min','!=',null)
                            ->where('permintaan_min','!=',null)
                            ->where('produksi_max','!=',null)
                            ->where('produksi_max','!=',null)
                            ->paginate(6);
        return view('orders.belanja', compact('products'));
    }

    public function cari(Request $request)
    {
        $products = Product::where('nama','like','%'.$request->cari.'%')
                            ->orWhere('harga','like','%'.$request->cari.'%')
                            ->orWhere('persediaan','like','%'.$request->cari.'%')
                            ->paginate(6);
        return view('orders.belanja', compact('products'));
    }

    public function produksi($request, $product)
    {
        $permintaanTurun = ($product->permintaan_max - $request->permintaan) / ($product->permintaan_max - $product->permintaan_min);
        $permintaanNaik = ($request->permintaan - $product->permintaan_min) / ($product->permintaan_max - $product->permintaan_min);

        $persediaanSedikit = ($product->persediaan_max - $product->persediaan) / ($product->persediaan_max - $product->persediaan_min);
        $persediaanBanyak = ($product->persediaan - $product->persediaan_min) / ($product->persediaan_max - $product->persediaan_min);

        $a1 = min($permintaanTurun, $persediaanBanyak);
        $a2 = min($permintaanTurun, $persediaanSedikit);
        $a3 = min($permintaanNaik, $persediaanBanyak);
        $a4 = min($permintaanNaik, $persediaanSedikit);
        $a  = $a1 + $a2 + $a3 + $a4;

        $z1 = (($a1 * ($product->produksi_max - $product->produksi_min)) - $product->produksi_max) / -1;
        $z2 = (($a2 * ($product->produksi_max - $product->produksi_min)) - $product->produksi_max) / -1;
        $z3 = ($a3 * ($product->produksi_max - $product->produksi_min)) + $product->produksi_min;
        $z4 = ($a4 * ($product->produksi_max - $product->produksi_min)) + $product->produksi_min;

        $az1  = $a1 * $z1;
        $az2  = $a2 * $z2;
        $az3  = $a3 * $z3;
        $az4  = $a4 * $z4;
        $az   = $az1 + $az2 + $az3 + $az4;

        $produksi = $az / $a;
        return (int)$produksi;
    }
}