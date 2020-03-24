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
                                        @if ($totalOrder)
                                            {{ $totalOrder }}
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
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Produksi</h5>
                                    <span class="h2 font-weight-bold mb-0">
                                        @if ($product->produksi)
                                            {{ $product->prodoksi }}
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

<div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
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
    <div class="col-xl-8 order-xl-1">
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
                <div class="row">
                    <div class="col-6 h6" id="created-at">
                    </div>
                    <div class="col-6 text-right h6" id="updated-at">
                    </div>
                </div>
                <h6 class="heading-small text-muted mb-4">Informasi Produk</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-nama">Nama</label>
                                <input disabled  type="text" id="input-nama" class="form-control form-control-alternative" value="{{ $product->nama }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-harga">Harga</label>
                                <input disabled  id="input-harga" class="form-control form-control-alternative" value="{{ $product->harga }}" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-satuan">Satuan</label>
                                <input disabled id="input-satuan" class="form-control form-control-alternative" value="{{ $product->satuan }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-persediaan">Persediaan</label>
                                <input disabled id="input-persediaan" class="form-control form-control-alternative" value="{{ $product->persediaan ? $product->persediaan : '-' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Batasan Permintaan -->
                <h6 class="heading-small text-muted mb-4">Batasan Permintaan</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-permintaan_min">Permintaan Minimal</label>
                                <input disabled id="input-permintaan_min" class="form-control form-control-alternative" value="{{ $product->permintaan_min ? $product->permintaan_min : '-' }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-permintaan_max">Permintaan Maximal</label>
                                <input disabled id="input-permintaan_max" class="form-control form-control-alternative" value="{{ $product->permintaan_max ? $product->permintaan_max : '-' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Batasan persediaan -->
                <h6 class="heading-small text-muted mb-4">Batasan persediaan</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-persediaan_min">Persediaan Minimal</label>
                                <input disabled id="input-persediaan_min" class="form-control form-control-alternative" value="{{ $product->persediaan_min ? $product->persediaan_min : '-' }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-persediaan_max">Persediaan Maximal</label>
                                <input disabled id="input-persediaan_max" class="form-control form-control-alternative" value="{{ $product->persediaan_max ? $product->persediaan_max : '-' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Batasan produksi -->
                <h6 class="heading-small text-muted mb-4">Batasan produksi</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-produksi_min">Produksi Minimal</label>
                                <input disabled id="input-produksi_min" class="form-control form-control-alternative" value="{{ $product->produksi_min ? $product->produksi_min : '-' }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-produksi_max">Produksi Maximal</label>
                                <input disabled id="input-produksi_max" class="form-control form-control-alternative" value="{{ $product->produksi_max ? $product->produksi_max : '-'}}">
                            </div>
                        </div>
                    </div>
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

            setInterval(function(){
                if (navigator.onLine) {
                    $('#updated-at').load(baseUrl + '/product/get-updated-at/' +id ).fadeIn("slow");
                    $('#created-at').load(baseUrl + '/product/get-created-at/' +id ).fadeIn("slow");
                } else {
                    alert('Harap periksa koneksi internet anda');
                }
            }, 1000);
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endpush
