@extends('layouts.app')

@section('title')
    Belanja
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection

@section('form-search-mobile')
<form form action="{{ route('belanja.cari') }}" method="GET" class="mt-4 mb-3 d-md-none">
    <div class="input-group input-group-rounded input-group-merge">
        <input name="cari" type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Cari ..." aria-label="Search" {{ request('cari') }}>
        <div class="input-group-prepend">
            <div class="input-group-text">
                <span class="fa fa-search"></span>
            </div>
        </div>
    </div>
</form>
@endsection

@section('form-search')
    <form action="{{ route('belanja.cari') }}" method="GET" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input name="cari" class="form-control" placeholder="Cari ..." type="text" value="{{ request('cari') }}">
            </div>
        </div>
    </form>
@endsection

@section('content-header')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card shadow h-100">
                        <div class="card-header border-0">
                            <h2 class="mb-0">BELANJA</h2>
                            <p class="mb-0 text-sm">Produk {{ config('app.name') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
@include('layouts.components.alert')
    <div class="row justify-content-center mt-5">
        @if (!$products->count())
            <div class="card">
                <div class="card-body">
                    <p class="font-weight-bold">Produk yang anda cari tidak tersedia</p>
                </div>
            </div>
        @else
            @foreach ($products as $product)
                <div class="card shadow h-100 col-lg-3" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset(Storage::url($product->foto)) }}" alt="{{ asset(Storage::url($product->foto)) }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->nama }}</h5>
                        <p class="card-text">Rp. {{ $product->harga }} / {{ $product->satuan }}</p>
                        <a href="{{ route('pesan',$product) }}" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            @endforeach
        @endif
        {{ $products->links() }}
    </div>

    <!-- The Modal -->
    <div id="foto-profil" class="modal-full">
        <!-- The Close Button -->
        <span class="tutup">&times;</span>
        <!-- Modal Content (The Image) -->
        <div class="container">
            <img class="image-zoom mw-100 img-center" id="img01">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            // Get the modal
            const modal = document.getElementById("foto-profil");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            const img = document.querySelectorAll('.img-foto');
            const modalImg = document.getElementById("img01");
            for (let index = 0; index < img.length; index++) {
                img[index].onclick = function(){
                    modal.style.display = "block";
                    modalImg.src = this.src;
                };
            }

            // Get the <span> element that tutups the modal
            const span = document.getElementsByClassName("tutup")[0];

            // When the user clicks on <span> (x), tutup the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            document.addEventListener('keyup',(e) => {
                if(e.key === "Escape") modal.style.display = "none";
            });
        });
    </script>
@endpush
