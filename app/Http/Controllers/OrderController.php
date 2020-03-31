<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Rules\Maximal;
use App\Rules\Minimal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(5);
        return view('orders.index', compact('orders'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cariPesanan(Request $request)
    {
        $orders = Order::orWhere('id','like','%'.$request->cari.'%')
                        ->orWhereHas('product',function ($q) use ($request){
                            $q->where('nama','like','%'.$request->cari.'%');
                        })
                        ->orWhereHas('product',function ($q) use ($request){
                            $q->where('harga','like','%'.$request->cari.'%');
                        })
                        ->orWhere('permintaan','like','%'.$request->cari.'%')
                        ->orWhere('keterangan','like','%'.$request->cari.'%')
                        ->paginate(5);
        return view('orders.index', compact('orders'));
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
            'permintaan' => ['required', new Minimal($product->permintaan_min), new Maximal($product->permintaan_max)]
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['keterangan'] = 'Belum diproses';
        $data['bukti_transfer'] = 'public/noimage-produk.jpg';
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
            'permintaan' => ['required', new Minimal($order->product->permintaan_min), new Maximal($order->product->permintaan_max)]
        ]);

        $data['produksi'] = $this->produksi($request, $order->product);
        $data['keterangan'] = 'Belum diproses';

        $order->update($data);
        return redirect(route('order.show',$order))->with('success','Pesanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->bukti_transfer != 'public/noimage-produk.jpg') {
            File::delete(storage_path('app/'.$order->bukti_transfer));
        }
        Order::destroy($order->id);
        return redirect('/order')->with('success','Pesanan berhasil dibatalkan');
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

    public function produksi($permintaan, $product)
    {
        $permintaanTurun = ($product->permintaan_max - $permintaan) / ($product->permintaan_max - $product->permintaan_min);
        $permintaanNaik = ($permintaan - $product->permintaan_min) / ($product->permintaan_max - $product->permintaan_min);

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

    public function updateBuktiTransfer(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order->bukti_transfer != 'public/noimage-produk.jpg') {
            File::delete(storage_path('app/'.$order->bukti_transfer));
        }
        $order->bukti_transfer = $request->file('bukti_transfer')->store('public/bukti-transfer');
        $order->keterangan = 'Belum diproses';
        $order->save();
    }

    public function verification(Request $request, Order $order)
    {
        $product = Product::findOrFail($order->product_id);
        if ($request->verifikasi == -1) {
            $request->validate([
                'alasan_penolakan' => ['required', 'string']
            ]);
            $order->alasan_penolakan = $request->alasan_penolakan;
            $order->keterangan = "Ditolak";
        } else {
            $order->keterangan = "Sedang dalam proses";
            $order->produksi = $this->produksi($order->permintaan, $order->product);
            $order->persediaan = $product->persediaan;
        }

        $product->persediaan = ($product->persediaan - $order->persediaan);
        $product->produksi = ($product->produksi + $order->produksi);

        $order->save();

        return redirect(route('product.show',$order->product))->with('success', 'Pesanan berhasil di verifikasi');
    }
}
