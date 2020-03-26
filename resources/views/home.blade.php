@extends('layouts.welcome')

@section('title')
    {{ config('app.name') }}
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <h1 class="text-center">
                        Selamat datang @auth {{auth()->user()->nama}} @endauth di UD. Special
                    </h1>
                </div>
            </div>
        </div>
    </div>

    @can('isDistributor')
        <div class="row justify-content-center mt-5">
            @foreach ($products as $product)
                <div class="card col-lg-3" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset(Storage::url($product->foto)) }}" alt="{{ asset(Storage::url($product->foto)) }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->nama }}</h5>
                        <p class="card-text">Rp. {{ $product->harga }} / {{ $product->satuan }}</p>
                        <a href="#" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            @endforeach
            {{ $products->links() }}
        </div>
    @endcan
@endsection
