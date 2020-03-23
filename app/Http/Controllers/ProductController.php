<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(5);
        $totalProduk = Product::all()->count();
        return view('products.index', compact('products','totalProduk'));
    }

    public function cari(Request $request)
    {
        $products = Product::where('nama','like','%'.$request->cari.'%')
                            ->orWhere('harga','like','%'.$request->cari.'%')
                            ->orWhere('persediaan','like','%'.$request->cari.'%');
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
            'harga'             => ['required','digits_between:3,11','min:0'],
            'foto'              => ['nullable','image','mimes:jpeg,png','max:2048'],
            'persediaan'        => ['nullable','numeric','min:0'],
            'persediaan_min'    => ['nullable','numeric','min:0'],
            'persediaan_max'    => ['nullable','numeric','min:0'],
            'permintaan_min'    => ['nullable','numeric','min:0'],
            'permintaan_max'    => ['nullable','numeric','min:0'],
            'produksi_min'      => ['nullable','numeric','min:0'],
            'produksi_max'      => ['nullable','numeric','min:0'],
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
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
