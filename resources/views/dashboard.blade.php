@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
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
                                    <h5 class="card-title text-uppercase text-muted mb-0">Produk Terjual</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $productTerjual }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="ni ni-bag-17"></i>
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
@include('layouts.components.alert')
<!-- Dark table -->
<div class="row">
    <div class="col">
        <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0 text-white">Daftar Produk</h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Persediaan</th>
                            <th scope="col">Pesanan</th>
                            <th scope="col">Permintaan</th>
                            <th scope="col">Produksi</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$products->count())
                            <tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>
                        @else
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle">
                                                <img class="img-foto-product" alt="{{ asset(Storage::url($product->foto)) }}" src="{{ asset(Storage::url($product->foto)) }}">
                                            </a>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $product->nama }}
                                    </td>
                                    <td>
                                        Rp. {{ $product->harga }} / {{ $product->satuan }}
                                    </td>
                                    <td>
                                        @if ($product->persediaan)
                                            {{ $product->persediaan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->orders)
                                            {{ $product->orders->where('keterangan','Belum diproses')->where('bukti_transfer','!=','public/noimage-produk.jpg')->count() }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->permintaan)
                                            {{ $product->permintaan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->produksi)
                                            {{ $product->produksi }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{ route('product.show',$product) }}"><i class="fas fa-fw fa-eye"></i>Detail</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-0 py-4">
                <nav aria-label="...">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0 text-white">Daftar Pengguna</h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nomor Hp</th>
                            <th scope="col">Peran</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <a href="#" class="avatar rounded-circle">
                                            <img class="img-foto" alt="{{ asset(Storage::url($user->avatar)) }}" src="{{ asset(Storage::url($user->avatar)) }}">
                                        </a>
                                    </div>
                                </th>
                                <td>
                                    <a href="{{ route("users.show",$user) }}">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    {{ $user->nama }}
                                </td>
                                <td>
                                    @if ($user->nomor_hp)
                                        {{ $user->nomor_hp }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $user->role->peran }}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('users.show',$user) }}"><i class="fas fa-fw fa-eye"></i>Detail</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-0 py-4">
                <nav aria-label="...">
                    {{ $users->links() }}
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
        <img class="image-zoom mw-100 img-center" id="img-profil">
    </div>
</div>

<!-- The Modal -->
<div id="foto-product" class="modal-full">
    <!-- The Close Button -->
    <span class="tutup">&times;</span>
    <!-- Modal Content (The Image) -->
    <div class="container">
        <img class="image-zoom mw-100 img-center" id="img-product">
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            const baseUrl = $('meta[name="base-url"]').attr('content');

            $('.img-foto-product').on('click',function () {
                $('#foto-product').css('display','block');
                $('#img-product').attr('src', $(this).attr('src'));
            });

            $('.img-foto').on('click',function () {
                $('#foto-profil').css('display','block');
                $('#img-profil').attr('src', $(this).attr('src'));
            });

            $('.tutup').on('click',function(){
                $('#foto-product').css('display','none');
                $('#foto-profil').css('display','none');
            });

            document.addEventListener('keyup',(e) => {
                if(e.key === "Escape") {
                    $('#foto-produk').css('display','none');
                    $('#foto-profil').css('display','none');
                }
            });

        });

    </script>
@endpush
