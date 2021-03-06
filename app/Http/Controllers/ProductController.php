<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Rules\Antara;
use App\Rules\Maximal;
use App\Rules\Minimal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->q) {
            $products = Product::where('nama','like','%'.$request->q.'%')
                            ->orWhere('harga','like','%'.$request->q.'%')
                            ->orWhere('persediaan','like','%'.$request->q.'%')
                            ->orderBy('id','desc')->paginate(5);
        } else {
            $products = Product::orderBy('id','desc')->paginate(5);
        }
        $totalProduk = Product::all()->count();
        return view('products.index', compact('products','totalProduk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'              => ['required','string','max:32'],
            'satuan'            => ['required','string','max:16'],
            'harga'             => ['required','digits_between:3,11','min:0'],
            'foto'              => ['nullable','image','mimes:jpeg,png','max:2048'],
            'persediaan'        => ['nullable','numeric','min:0', new Antara($request->persediaan_min, $request->persediaan_max)],
            'persediaan_min'    => ['nullable','numeric','min:0', new Maximal($request->persediaan_max)],
            'persediaan_max'    => ['nullable','numeric', new Minimal($request->persediaan_min)],
            'permintaan_min'    => ['nullable','numeric','min:0', new Maximal($request->permintaan_max)],
            'permintaan_max'    => ['nullable','numeric', new Minimal($request->permintaan_min)],
            'produksi_min'      => ['nullable','numeric','min:0', new Maximal($request->produksi_max)],
            'produksi_max'      => ['nullable','numeric', new Minimal($request->produksi_min)],
        ]);

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('public/foto-produk');
        } else {
            $data['foto'] = 'public/noimage-produk.jpg';
        }

        $product = Product::create($data);
        return redirect()->route('product.show',$product)->with('success','Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Product $product)
    {
        if($request->q){
            $pesananMasuk = Order::where('id','like',$request->q)->where('keterangan','Belum diproses')->where('bukti_transfer','!=','public/noimage-produk.jpg')->orderBy('id','desc')->paginate(5);
            $pesananProses = Order::where('id','like',$request->q)->where('keterangan','Sedang dalam proses')->orderBy('id','desc')->paginate(5);
            $pesananKirim = Order::where('id','like',$request->q)->where('keterangan','Sedang dalam pengiriman')->orderBy('id','desc')->paginate(5);
            $pesananSelesai = Order::where('id','like',$request->q)->where('keterangan','Diterima')->orderBy('id','desc')->paginate(5);
        } else {
            $pesananMasuk = Order::where('product_id',$product->id)->where('keterangan','Belum diproses')->where('bukti_transfer','!=','public/noimage-produk.jpg')->orderBy('id','desc')->paginate(5);
            $pesananProses = Order::where('product_id',$product->id)->where('keterangan','Sedang dalam proses')->orderBy('id','desc')->paginate(5);
            $pesananKirim = Order::where('product_id',$product->id)->where('keterangan','Sedang dalam pengiriman')->orderBy('id','desc')->paginate(5);
            $pesananSelesai = Order::where('product_id',$product->id)->where('keterangan','Diterima')->orderBy('id','desc')->paginate(5);
        }
        return view('products.show', compact('product','pesananMasuk','pesananProses','pesananKirim','pesananSelesai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($product->permintaan || $product->produksi) {
            $data = $request->validate([
                'nama'              => ['required','string','max:32'],
                'satuan'            => ['required','string','max:16'],
                'harga'             => ['required','digits_between:3,11','min:0'],
                'persediaan'        => ['required','numeric','min:0', new Antara($request->persediaan_min, $request->persediaan_max)],
                'persediaan_min'    => ['required','numeric','min:0', new Maximal($request->persediaan_max)],
                'persediaan_max'    => ['required','numeric', new Minimal($request->persediaan_min)],
                'permintaan_min'    => ['required','numeric','min:0', new Maximal($request->permintaan_max)],
                'permintaan_max'    => ['required','numeric', new Minimal($request->permintaan_min)],
                'produksi_min'      => ['required','numeric','min:0', new Maximal($request->produksi_max)],
                'produksi_max'      => ['required','numeric',new Minimal($request->produksi_min)],
            ]);
        } else {
            $data = $request->validate([
                'nama'              => ['required','string','max:32'],
                'satuan'            => ['required','string','max:16'],
                'harga'             => ['required','digits_between:3,11','min:0'],
                'persediaan'        => ['nullable','numeric','min:0', new Antara($request->persediaan_min, $request->persediaan_max)],
                'persediaan_min'    => ['nullable','numeric','min:0', new Maximal($request->persediaan_max)],
                'persediaan_max'    => ['nullable','numeric', new Minimal($request->persediaan_min)],
                'permintaan_min'    => ['nullable','numeric','min:0', new Maximal($request->permintaan_max)],
                'permintaan_max'    => ['nullable','numeric', new Minimal($request->permintaan_min)],
                'produksi_min'      => ['nullable','numeric','min:0', new Maximal($request->produksi_max)],
                'produksi_max'      => ['nullable','numeric', new Minimal($request->produksi_min)],
            ]);
        }

        if ($request->nama == $product->nama &&
            $request->harga == $product->harga &&
            $request->persediaan == $product->persediaan &&
            $request->persediaan_min == $product->persediaan_min &&
            $request->persediaan_max == $product->persediaan_max &&
            $request->permintaan_min == $product->permintaan_min &&
            $request->permintaan_max == $product->permintaan_max &&
            $request->produksi_min == $product->produksi_min &&
            $request->produksi_max == $product->produksi_max
        ) {
            return redirect()->back()->with('error','Tidak ada perubahan yang berhasil disimpan');
        }

        $product->update($data);
        return redirect()->back()->with('success','Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->foto != 'public/noimage-produk.jpg') {
            File::delete(storage_path('app/'.$product->foto));
        }

        if ($product->orders) {
            foreach ($product->orders as $order) {
                if ($order->bukti_transfer != 'public/noimage-produk.jpg') {
                    File::delete(storage_path('app/'.$order->bukti_transfer));
                }
            }
        }

        Product::destroy($product->id);
        return redirect('/product')->with('success','Produk "'.$product->nama.'" berhasil dihapus');
    }

    public function updateFoto(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product->foto != 'public/noimage-produk.jpg') {
            File::delete(storage_path('app/'.$product->foto));
        }
        $product->foto = $request->file('foto')->store('public/foto-produk');
        $product->save();
    }
}
