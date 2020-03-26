@extends('layouts.app')

@section('title')
    Pesan {{ $order->product->nama }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection

@section('content-header')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-header border-0">
                        <h2 class="mb-0">{{ $order->product->nama }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="alert alert-info" role="alert">
    <strong>Info!</strong> Status Keterangan : <strong>{{ $order->keterangan }}</strong>
</div>
<div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
        <div class="card card-profile shadow">
            <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                            <img id="avatar" src="{{asset(Storage::url($order->product->foto))}}" alt="{{asset(Storage::url($order->product->foto))}}" class="rounded-circle" style="max-height: 150px; max-width: 200px">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 pt-md-4 pb-0 pb-md-4">
            </div>
            <div class="card-body pt-0 pt-md-4 mt-5">
                <div class="text-center">
                    <h3>
                        {{ $order->product->nama }}
                    </h3>
                    <div class="h5 font-weight-300">
                        Rp. {{ $order->product->harga }} / {{ $order->product->satuan }}
                    </div>
                    @if ($order->product->persediaan)
                        <div class="h5 mt-4">
                            Persediaan : {{ $order->product->persediaan }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow mt-3">
            <div class="card-head pt-2">
                <h5 class="text-center h4">Bukti Transfer</h5>
            </div>
            <div class="card-body">
                <a href="" title="Klik untuk mengunggah gambar">
                    <img class="mw-100" src="{{ asset('storage/noimage-produk.jpg') }}" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">Pesan {{ $order->product->nama }}</h3>
            </div>
            <div class="card-body">
                @include('layouts.components.alert')
                <form method="POST" action="{{ route('order.update',$order->product) }}">
                    @csrf @method('patch')
                    <h6 class="heading-small text-muted mb-4">Informasi Produk</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-nama">Nama</label>
                                    <input disabled type="text" id="input-nama" class="form-control form-control-alternative" placeholder="Masukkan nama ..." value="{{ $order->product->nama }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-harga">Harga</label>
                                    <input disabled id="input-harga" class="form-control form-control-alternative" placeholder="Masukkan harga ..." value="{{ $order->product->harga }}" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-satuan">Satuan</label>
                                    <input disabled id="input-satuan" class="form-control form-control-alternative" placeholder="Masukkan satuan ..." value="{{ $order->product->satuan }}" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-persediaan">Persediaan</label>
                                    <input disabled type="number" id="input-persediaan" class="form-control form-control-alternative" placeholder="Masukkan persediaan ..." value="{{ $order->product->persediaan }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <!-- Permintaan -->
                    <div class="form-group">
                        <label class="form-control-label" for="input-permintaan">Jumlah Permintaan</label>
                        <input name="permintaan" type="number" id="input-permintaan" class="form-control form-control-alternative @error('permintaan') is-invalid @enderror" placeholder="Masukkan jumlah permintaan ..." value="{{ old('permintaan', $order->permintaan) }}">
                        @error('permintaan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <hr class="my-4" />
                    <h2>Total Harga = <span id="total-harga">Rp. {{ $order->permintaan * $order->product->harga }}</span></h2>
                    <hr class="my-4" />
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Ubah</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('belanja') }}" class="btn btn-block btn-light">Kembali</a>
                        </div>
                    </div>
                </form>
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

            $('#input-permintaan').on('keyup', function(){
                let totalHarga = $(this).val() * {{ $order->product->harga }};
                $('#total-harga').html('Rp. '+ totalHarga);
            });

            $('#input-permintaan').on('change', function(){
                let totalHarga = $(this).val() * {{ $order->product->harga }};
                $('#total-harga').html('Rp. '+ totalHarga);
            });
        });
    </script>
@endpush
