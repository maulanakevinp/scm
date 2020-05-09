<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Rules\Maximal;
use App\Rules\Minimal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->q) {
            $orders = Order::orWhere('id','like','%'.$request->q.'%')
                        ->orWhereHas('product',function ($q) use ($request){
                            $q->where('nama','like','%'.$request->q.'%');
                        })
                        ->orWhereHas('product',function ($q) use ($request){
                            $q->where('harga','like','%'.$request->q.'%');
                        })
                        ->orWhere('permintaan','like','%'.$request->q.'%')
                        ->orWhereHas('status',function ($q) use ($request){
                            $q->where('keterangan','like','%'.$request->q.'%');
                        })
                        ->orderBy('id','desc')->paginate(5);
        } else {
            $orders = Order::orderBy('id','desc')->paginate(5);
        }

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
            'permintaan' => ['required', 'numeric', new Minimal($product->minimal_permintaan)]
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['status_id'] = 1;
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
        if ($order->status_id == 1 || $order->status_id == 2) {
            $data = $request->validate([
                'permintaan' => ['required', 'numeric', 'min:1']
            ]);
        }

        if ($request->verifikasi == 1) {
            $data['status_id'] = 5;
        } else {
            $data['status_id'] = 1;
        }

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
    public function belanja(Request $request)
    {
        if ($request->q) {
            $products = Product::where('persediaan','!=',null)
                                ->where('foto','!=','public/noimage-produk.jpg')
                                ->where('nama','like','%'.$request->q.'%')
                                ->orWhere('satuan','like','%'.$request->q.'%')
                                ->orWhere('harga','like','%'.$request->q.'%')
                                ->orWhere('persediaan','like','%'.$request->q.'%')
                                ->paginate(6);
        } else {
            $products = Product::where('persediaan','!=',null)
                                ->where('foto','!=','public/noimage-produk.jpg')
                                ->paginate(6);
        }

        return view('orders.belanja', compact('products'));
    }

    public function produksi($dataPermintaan, $dataPersediaan, $dataProduksi, $permintaan, $persediaan)
    {
        $permintaanTurun = (max($dataPermintaan) - $permintaan)     /(max($dataPermintaan) - min($dataPermintaan));
        $permintaanNaik = ($permintaan - min($dataPermintaan))      /(max($dataPermintaan) - min($dataPermintaan));

        $persediaanSedikit = (max($dataPersediaan) - $persediaan)   /(max($dataPersediaan) - min($dataPersediaan));
        $persediaanBanyak = ($persediaan - min($dataPersediaan))    /(max($dataPersediaan) - min($dataPersediaan));

        $a1 = min($permintaanTurun, $persediaanBanyak);
        $a2 = min($permintaanTurun, $persediaanSedikit);
        $a3 = min($permintaanNaik, $persediaanBanyak);
        $a4 = min($permintaanNaik, $persediaanSedikit);
        $a  = $a1 + $a2 + $a3 + $a4;

        $z1 = (($a1 * (max($dataProduksi) - min($dataProduksi))) - max($dataProduksi)) / -1;
        $z2 = (($a2 * (max($dataProduksi) - min($dataProduksi))) - max($dataProduksi)) / -1;
        $z3 = ($a3 * (max($dataProduksi) - min($dataProduksi))) + min($dataProduksi);
        $z4 = ($a4 * (max($dataProduksi) - min($dataProduksi))) + min($dataProduksi);

        $az1  = $a1 * $z1;
        $az2  = $a2 * $z2;
        $az3  = $a3 * $z3;
        $az4  = $a4 * $z4;
        $az   = $az1 + $az2 + $az3 + $az4;

        $produksi = $az / $a;
        // var_dump('permintaan Maximal = '.max($dataPermintaan));
        // var_dump('permintaan Minimal = '.min($dataPermintaan));
        // var_dump('permintaan = '.$permintaan);
        // var_dump('persediaan Maximal = '.max($dataPersediaan));
        // var_dump('persediaan Minimal = '.min($dataPersediaan));
        // var_dump('persediaan = '.$persediaan);
        // var_dump('produksi Maximal = '.max($dataProduksi));
        // var_dump('produksi Minimal = '.min($dataProduksi));
        // var_dump('permintaan Turun = '.$permintaanTurun);
        // var_dump('permintaan Naik = '.$permintaanNaik);
        // var_dump('persediaan Banyak = '.$persediaanBanyak);
        // var_dump('persediaan Sedikit = '.$persediaanSedikit);
        // var_dump('a1 = '.$a1);
        // var_dump('a2 = '.$a2);
        // var_dump('a3 = '.$a3);
        // var_dump('a4 = '.$a4);
        // var_dump('a = '.$a);
        // var_dump('z1 = '.$z1);
        // var_dump('z2 = '.$z2);
        // var_dump('z3 = '.$z3);
        // var_dump('z4 = '.$z4);
        // var_dump('az1 = '.$az1);
        // var_dump('az2 = '.$az2);
        // var_dump('az3 = '.$az3);
        // var_dump('az4 = '.$az4);
        // var_dump('az = '.$az);
        // var_dump('produksi = '.$produksi);
        // die;
        return (int)$produksi;
    }

    public function updateBuktiTransfer(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'bukti_transfer' => ['required','image','mimes:jpeg,png','max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'     => true,
                'message'   => $validator->errors()->all(),
                'bukti_transfer'    => $order->bukti_transfer
            ]);
        }

        if ($order->bukti_transfer != 'public/noimage-produk.jpg') {
            File::delete(storage_path('app/'.$order->bukti_transfer));
        }
        $order->bukti_transfer = $request->file('bukti_transfer')->store('public/bukti-transfer');
        $order->status_id = 1;
        $order->save();

        return response()->json([
            'error'             => false,
            'message'           => 'Bukti transfer berhasil dikirim',
            'bukti_transfer'    => $order->bukti_transfer
        ]);
    }

    public function verification(Request $request, Order $order)
    {
        $orders = Order::whereProductId($order->product_id)->where('status_id','>',2)->get();
        $product = Product::findOrFail($order->product_id);
        $permintaan = array();
        $persediaan = array();
        $produksi = array();
        if ($request->verifikasi == -1) {
            $request->validate([
                'alasan_penolakan' => ['required', 'string']
            ]);
            $order->alasan_penolakan = $request->alasan_penolakan;
            $order->status_id = 2;
        } elseif ($request->verifikasi == 1) {
            $order->status_id      = 3;
            $product->permintaan    = $product->permintaan + $order->permintaan;
            if ($orders->count() >= 2) {
                foreach ($orders as $data) {
                    array_push($permintaan, $data->permintaan);
                    array_push($persediaan, $data->persediaan);
                    array_push($produksi, $data->produksi);
                }
                $order->produksi = $this->produksi($permintaan,$persediaan,$produksi,$product->permintaan,$product->persediaan);
                if ($order->produksi < $order->permintaan) {
                    $order->produksi = $order->produksi + $order->permintaan;
                }
            } else {
                if ($order->permintaan > $product->persediaan) {
                    $order->produksi = ($order->permintaan - $product->persediaan) + 1;
                } else {
                    $order->produksi = 1;
                }
            }

            $order->persediaan      = $product->persediaan;
            $product->produksi      = $product->produksi + $order->produksi;
        } elseif($request->verifikasi == 2) {
            $product->permintaan    = ($product->permintaan - $order->permintaan);
            $product->persediaan    = $product->persediaan - $order->permintaan + $order->produksi;
            $product->produksi      = ($product->produksi - $order->produksi);
            $order->status_id       = 4;
        }
        $product->save();
        $order->save();

        return redirect(route('product.show',$order->product))->with('success', 'Pesanan berhasil di verifikasi');
    }
}
