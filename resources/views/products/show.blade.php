@extends('layouts.app')

@section('title')
Detail Produk {{ $product->nama }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <meta name="product-id" content="{{ $product->id }}">

@endsection

@section('content-header')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan</h5>
                                    <span class="h2 font-weight-bold mb-0">
                                        @if ($product->orders)
                                            {{ $product->orders->count() }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Permintaan</h5>
                                    <span class="h2 font-weight-bold mb-0">
                                        @if ($product->permintaan)
                                            {{ $product->permintaan }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="ni ni-bag-17"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Produksi</h5>
                                    <span class="h2 font-weight-bold mb-0">
                                        @if ($product->produksi)
                                            {{ $product->produksi }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                                        <i class="fas fa-history"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
@if ($product->foto == 'public/noimage-produk.jpg' || $product->persediaan == null || $product->persediaan_min == null || $product->persediaan_max == null || $product->permintaan_min == null || $product->permintaan_max == null || $product->produksi_min == null || $product->produksi_max == null )
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="ni ni-bell-55"></i></span>
        <span class="alert-text">
            <strong>Perhatian!!!</strong>
            Harap isi semua data dan foto agar dapat dipesan distributor
        </span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-xl-3 order-xl-2 mb-5 mb-xl-0">
        <div class="card card-profile shadow">
            <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                            <img id="avatar" src="{{asset(Storage::url($product->foto))}}" alt="{{asset(Storage::url($product->foto))}}" class="rounded-circle" style="max-height: 150px; max-width: 200px">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 pt-md-4 pb-0 pb-md-4">
            </div>
            <div class="card-body pt-0 pt-md-4 pt-5 mt-5">
                <div class="text-center">
                    <h3>
                        {{ $product->nama }}
                    </h3>
                    <div class="h5 font-weight-300">
                        Rp. {{ $product->harga }} / {{ $product->satuan }}
                    </div>
                    @if ($product->persediaan)
                        <div class="h5 mt-4">
                            Persediaan : {{ $product->persediaan }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 order-xl-1">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row">
                    <div class="col-8">
                        <h3 class="mb-0">Detail Produk {{ $product->nama }}</h3>
                    </div>
                    <div class="col-4 text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only" href="#" role="button" title="Option"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="{{ route('product.edit',$product) }}"><i class="fas fa-fw fa-edit"></i>Ubah</a>
                                <a class="dropdown-item" data-toggle="modal" href="#modal-delete"><i class="fas fa-fw fa-trash"></i>Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.components.alert')

                <div class="row mb-3">
                    <div class="col-6 h6" id="created-at">
                    </div>
                    <div class="col-6 text-right h6" id="updated-at">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 border-right h5">
                        <table class="">
                            <tbody>
                                <tr class="">
                                    <td>Permintaan Maximal</td>
                                    <td>: {{ $product->permintaan_max }}</td>
                                </tr>
                                <tr>
                                    <td>Permintaan Minimal</td>
                                    <td>: {{ $product->permintaan_min }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 border-right h5" >
                        <table class="">
                            <tbody>
                                <tr>
                                    <td>Persediaan Maximal</td>
                                    <td>: {{ $product->persediaan_max }}</td>
                                </tr>
                                <tr>
                                    <td>Persediaan Minimal</td>
                                    <td>: {{ $product->persediaan_min }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 h5" >
                        <table class="">
                            <tbody>
                                <tr>
                                    <td>Produksi Maximal</td>
                                    <td>: {{ $product->produksi_max }}</td>
                                </tr>
                                <tr>
                                    <td>Produksi Minimal</td>
                                    <td>: {{ $product->produksi_min }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2 class="h1 mt-3 mb-0">Pesanan</h2>
<div class="nav-wrapper pt-2">
    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                <i class="ni ni-cloud-download-95 mr-2"></i>Pesanan masuk <span class="badge badge-default text-white">{{ $product->orders->where('keterangan','Belum diproses')->where('bukti_transfer','!=','public/noimage-produk.jpg')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                <i class="ni ni-atom mr-2"></i>Pesanan dalam proses <span class="badge badge-default text-white">{{ $product->orders->where('keterangan','Sedang dalam proses')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                <i class="ni ni-cloud-upload-96 mr-2"></i>Pesanan dalam pengiriman <span class="badge badge-default text-white">{{ $product->orders->where('keterangan','Sedang dalam pengiriman')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                <i class="ni ni-check-bold mr-2"></i>Pesanan Selesai <span class="badge badge-default text-white">{{ $product->orders->where('keterangan','Diterima')->count() }}</span>
            </a>
        </li>
    </ul>
</div>
<div class="card bg-default shadow h-100 ">
    <div class="card-body p-0">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                <div class="table-responsive">
                    <table class="table align-items-center table-dark table-flush">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email Pemesan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tanggal Pesan</th>
                                <th scope="col">Tanggal Disetujui</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$product->orders->where('keterangan','Belum diproses')->where('bukti_transfer','!=','public/noimage-produk.jpg')->count())
                                <tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>
                            @else
                                @foreach ($product->orders->where('keterangan','Belum diproses')->where('bukti_transfer','!=','public/noimage-produk.jpg') as $order)
                                    <tr>
                                        <th scope="row">
                                            {{ $order->id }}
                                        </th>
                                        <td>
                                            {{ $order->user->email }}
                                        </td>
                                        <td>
                                            {{ $order->permintaan }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                            @if ($order->keterangan == "Diterima")
                                                {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm" href="{{ route('order.edit',$order) }}" title="Detail"><i class="fas fa-fw fa-eye text-default"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                <div class="table-responsive">
                    <table class="table align-items-center table-dark table-flush">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email Pemesan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tanggal Pesan</th>
                                <th scope="col">Tanggal Disetujui</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$product->orders->where('keterangan','Sedang dalam proses')->count())
                                <tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>
                            @else
                                @foreach ($product->orders->where('keterangan','Sedang dalam proses') as $order)
                                    <tr>
                                        <th scope="row">
                                            {{ $order->id }}
                                        </th>
                                        <td>
                                            {{ $order->user->email }}
                                        </td>
                                        <td>
                                            {{ $order->permintaan }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                            @if ($order->keterangan == "Diterima")
                                                {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm" href="{{ route('order.edit',$order) }}" title="Detail"><i class="fas fa-fw fa-eye text-default"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                <div class="table-responsive">
                    <table class="table align-items-center table-dark table-flush">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email Pemesan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tanggal Pesan</th>
                                <th scope="col">Tanggal Disetujui</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$product->orders->where('keterangan','Sedang dalam pengiriman')->count())
                                <tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>
                            @else
                                @foreach ($product->orders->where('keterangan','Sedang dalam pengiriman') as $order)
                                    <tr>
                                        <th scope="row">
                                            {{ $order->id }}
                                        </th>
                                        <td>
                                            {{ $order->user->email }}
                                        </td>
                                        <td>
                                            {{ $order->permintaan }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                            @if ($order->keterangan == "Diterima")
                                                {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm" href="{{ route('order.edit',$order) }}" title="Detail"><i class="fas fa-fw fa-eye text-default"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                <div class="table-responsive">
                    <table class="table align-items-center table-dark table-flush">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email Pemesan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tanggal Pesan</th>
                                <th scope="col">Tanggal Disetujui</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$product->orders->where('keterangan','Diterima')->count())
                                <tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>
                            @else
                                @foreach ($product->orders->where('keterangan','Diterima') as $order)
                                    <tr>
                                        <th scope="row">
                                            {{ $order->id }}
                                        </th>
                                        <td>
                                            {{ $order->user->email }}
                                        </td>
                                        <td>
                                            {{ $order->permintaan }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                            @if ($order->keterangan == "Diterima")
                                                {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm" href="{{ route('order.edit',$order) }}" title="Detail"><i class="fas fa-fw fa-eye text-default"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-danger">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-delete">Hapus Produk?</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="py-3 text-center">
                    <i class="ni ni-bell-55 ni-3x"></i>
                    <h4 class="heading mt-4">Perhatian!!</h4>
                    <p>Menghapus Produk akan menghapus semua data yang dimilikinya</p>
                    <p><strong>Apakah Anda yakin ingin menghapus {{ $product->nama }} ???</strong></p>
                </div>

            </div>

            <div class="modal-footer">
                <form action="{{ route('product.destroy',$product) }}" method="POST" >
                    @csrf @method('delete')
                    <button type="submit" class="btn btn-white">Yakin</button>
                </form>
                <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tidak</button>
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
            // Get the modal
            const modal = document.getElementById("foto-profil");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            const img = document.getElementById("avatar");
            const modalImg = document.getElementById("img01");
            img.onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
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

            const id = $('meta[name="product-id"]').attr('content');
            const baseUrl = $('meta[name="base-url"]').attr('content');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const data = {
                id: id,
                _token: csrfToken,
            };
            setInterval(function(){
                if (navigator.onLine) {
                    $.post(baseUrl + '/product/get-updated-at', data, function(hasil){
                        document.getElementById('updated-at').innerHTML = hasil;
                    });
                    $.post(baseUrl + '/product/get-created-at', data, function(hasil){
                        document.getElementById('created-at').innerHTML = hasil;
                    });
                } else {
                    alert('Harap periksa koneksi internet anda');
                }
            }, 1000);
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endpush
