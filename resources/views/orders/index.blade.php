@extends('layouts.app')

@section('title')
Pesanan Saya
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection

@section('form-search-mobile')
<form form action="{{ route('order.cari') }}" method="GET" class="mt-4 mb-3 d-md-none">
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
    <form action="{{ route('order.cari') }}" method="GET" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
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
                        <h2 class="mb-0">Pesanan Saya</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('layouts.components.alert')
<!-- Dark table -->
<div class="row">
    <div class="col">
        <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0 text-white">Daftar Pesanan</h3>
                    </div>
                    <div class="col-4 text-right">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Tanggal Disetujui</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$orders->count())
                            <tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>
                        @else
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row" class="text-right">
                                        {{ $order->id }}
                                    </th>
                                    <td>
                                        {{ $order->product->nama }}
                                    </td>
                                    <td>
                                        {{ $order->product->harga }}
                                    </td>
                                    <td>
                                        {{ $order->permintaan }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                    </td>
                                    <td>
                                        @if ($order->keterangan == "Sedang dalam proses")
                                            {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $order->keterangan }}
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-info btn-sm" href="{{ route('order.show',$order) }}" title="Detail"><i class="fas fa-fw fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-0 py-4">
                <nav aria-label="...">
                    {{ $orders->links() }}
                </nav>
            </div>
        </div>
    </div>
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
            const baseUrl = $('meta[name="base-url"]').attr('content');

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
