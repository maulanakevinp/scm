@extends('layouts.app')

@section('title')
    Detail Pesananan {{ $order->product->nama }}
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
                        <h2 class="mb-0">{{ $order->product->nama }} #{{ $order->id }} </h2>
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
                                <img id="img-foto-produk" src="{{asset(Storage::url($order->product->foto))}}" alt="{{asset(Storage::url($order->product->foto))}}" class="rounded-circle" style="max-height: 150px; max-width: 200px">
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
                                @if ($order->status_id == 1)
                                    Persediaan : {{ $order->product->persediaan }}
                                @else
                                    Persediaan : {{ $order->persediaan }} <br>
                                    Produksi : {{ $order->produksi }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card shadow mt-3">
                <div class="card-head pt-2">
                    <h5 class="text-center h4">
                        Bukti Transfer
                    </h5>
                </div>
                <div class="card-body text-center">
                    <a href="#">
                        <img id="img-bukti-transfer" class="mw-100" src="{{asset(Storage::url($order->bukti_transfer))}}" alt="{{asset(Storage::url($order->bukti_transfer))}}">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3 class="mb-0">Pesanan {{ $order->product->nama }} #{{ $order->id }}</h3>
                </div>
                <div class="card-body">
                    @include('layouts.components.alert')
                    <form method="POST" action="{{ route('order.verification',$order) }}">
                        @csrf @method('patch')
                        <div class="form-group">
                            <label class="form-control-label" for="input-permintaan">Jumlah Permintaan</label>
                            <input disabled type="number" id="input-permintaan" class="form-control form-control-alternative" value="{{ $order->permintaan }}">
                        </div>
                        <hr class="my-4" />
                        <h2>Total Harga = <span id="total-harga">Rp. {{ $order->permintaan * $order->product->harga }}</span></h2>
                        <hr class="my-4" />
                        <div class="row">
                            @can('isProdusen')
                                @if ($order->status_id == 1)
                                <div class="col-4">
                                    <input type="hidden" name="verifikasi" value="1">
                                    <button type="submit" class="btn btn-success btn-block">Terima</button>
                                </div>
                                <div class="col-4">
                                    <a href="#modal-delete" data-toggle="modal" class="btn btn-danger btn-block">Tolak</a>
                                </div>
                                @elseif($order->status_id == 3)
                                <div class="col-4">
                                    <input type="hidden" name="verifikasi" value="2">
                                    <button type="submit" class="btn btn-success btn-block">Kirim</button>
                                </div>
                                @endif
                            @endcan

                            <div class="col-4">
                                <a href="{{ route('product.show',$order->product) }}" class="btn btn-block btn-light">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="modal-foto-produk" class="modal-full">
        <!-- The Close Button -->
        <span class="tutup">&times;</span>
        <!-- Modal Content (The Image) -->
        <div class="container">
            <img class="image-zoom mw-100 img-center" id="img01">
        </div>
    </div>

    <!-- The Modal -->
    <div id="modal-bukti-transfer" class="modal-full">
        <!-- The Close Button -->
        <span class="tutup">&times;</span>
        <!-- Modal Content (The Image) -->
        <div class="container">
            <img class="image-zoom mw-100 img-center" id="img02">
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-delete">Tolak Pesanan?</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="{{ route('order.verification',$order) }}" method="POST" >
                    @csrf @method('patch')
                    <div class="modal-body">

                        <div class="py-3 text-center">
                            <div class="form-group">
                                <label for="alasan">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan" id="alasan" rows="2" class="form-control @error('alasan_penolakan') is-invalid @enderror">{{ old("alasan_penolakan") }}</textarea>
                                @error('alasan_penolakan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="verifikasi" value="-1">
                        <button type="submit" class="btn btn-white">Yakin</button>
                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tidak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#img-foto-produk').on('click',function () {
                $('#modal-foto-produk').css('display','block');
                $('#img01').attr('src', $(this).attr('src'));
            });

            $('#img-bukti-transfer').on('click',function () {
                $('#modal-bukti-transfer').css('display','block');
                $('#img02').attr('src', $(this).attr('src'));
            });

            $('.tutup').on('click',function(){
                $('#modal-foto-produk').css('display','none');
                $('#modal-bukti-transfer').css('display','none');
            });

            document.addEventListener('keyup',(e) => {
                if(e.key === "Escape") {
                    $('#modal-foto-produk').css('display','none');
                    $('#modal-bukti-transfer').css('display','none');
                }
            });

        });
    </script>
@endpush
