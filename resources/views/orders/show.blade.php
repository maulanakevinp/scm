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
                        <h2 class="mb-0">{{ $order->product->nama }} #{{ $order->id }} </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    @if ($order->status_id == 1)
        <div class="alert alert-info" role="alert">
            <strong>Info!</strong> Status Keterangan : <strong>{{ $order->status->keterangan }}.</strong>
            @if ($order->bukti_transfer == 'public/noimage-produk.jpg')
                <strong>Silahkan upload bukti transfer</strong>
            @else
                Harap tunggu konfirmasi dari kami
            @endif
        </div>
    @elseif($order->status_id == 2)
        <div class="alert alert-danger" role="alert">
            <strong>Info!</strong> Status Keterangan : <strong>{{ $order->status->keterangan }}</strong>
            <p>({{ $order->alasan_penolakan }})</p>
        </div>
    @elseif($order->status_id == 3)
        <div class="alert alert-warning" role="alert">
            <strong>Info!</strong> Status Keterangan : <strong>{{ $order->status->keterangan }}</strong>
        </div>
    @elseif($order->status_id == 4)
        <div class="alert alert-default" role="alert">
            <strong>Info!</strong> Status Keterangan : <strong>{{ $order->status->keterangan }}</strong>
        </div>
    @else
        <div class="alert alert-success" role="alert">
            <strong>Info!</strong> Status Keterangan : <strong>{{ $order->status->keterangan }}</strong>
        </div>
    @endif
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
                        <div class="h5 mt-4">
                            Persediaan : {{ $order->persediaan ? $order->persediaan : $order->product->persediaan }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-3">
                <div class="card-head pt-2">
                    <h5 class="text-center h4">
                        @if ($order->bukti_transfer == null)
                            Silahkan Upload Bukti Transfer
                        @else
                            Bukti Transfer
                        @endif
                    </h5>
                </div>
                <div class="card-body text-center">
                    <a href="#">
                        <img id="img-bukti-transfer" class="mw-100" src="{{asset(Storage::url($order->bukti_transfer))}}" alt="{{asset(Storage::url($order->bukti_transfer))}}">
                    </a>
                    @if ($order->status_id == 1 || $order->status_id == 2)
                        <button title="klik untuk mengupload bukti transfer" id="btn-upload" class="btn btn-success btn-block mt-2"><i class="ni ni-cloud-upload-96"></i> Upload</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3 class="mb-0">Pesan {{ $order->product->nama }}</h3>
                </div>
                <div id="card" class="card-body">
                    @include('layouts.components.alert')
                    <div id="alert" class="alert alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i></i></span>
                        <span class="alert-text">
                        </span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('order.update',$order) }}">
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
                                        <input disabled type="number" id="input-persediaan" class="form-control form-control-alternative" placeholder="Masukkan persediaan ..." value="{{ $order->persediaan ? $order->persediaan : $order->product->persediaan }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Permintaan -->
                        <div class="form-group">
                            <label class="form-control-label" for="input-permintaan">Jumlah Permintaan</label>

                            <input name="permintaan" type="number" id="input-permintaan" class="form-control form-control-alternative @error('permintaan') is-invalid @enderror" placeholder="Masukkan jumlah permintaan ..." value="{{ old('permintaan', $order->permintaan) }}" @if ($order->status_id != 1 && $order->status_id != 2) disabled @endif>
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
                            @if ($order->status_id == 4)
                                <div class="col-6">
                                    <input type="hidden" name="verifikasi" value="1">
                                    <button type="submit" class="btn btn-success btn-block">Terima</button>
                                </div>
                            @elseif($order->status_id == 1 || $order->status_id == 2 )
                                <div class="@if ($order->status_id == 1 || $order->status_id == 2) col-4 @else col-6 @endif">
                                    <button type="submit" class="btn btn-primary btn-block">Ubah</button>
                                </div>
                                <div class="col-4">
                                    <a href="#modal-delete" data-toggle="modal" class="btn btn-danger btn-block">Batal</a>
                                </div>
                            @endif
                            <div class="@if ($order->status_id == 1 || $order->status_id == 2) col-4 @elseif($order->status_id == 5 || $order->status_id == 3) col-12 @else col-6 @endif">
                                <a href="{{ route('order.index') }}" class="btn btn-block btn-light">Kembali</a>
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

    <input type="file" name="bukti_transfer" id="input-bukti-transfer" data-id="{{ $order->id }}" style="display: none">

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-delete">Batal Memesan?</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">Perhatian!!</h4>
                        <p><strong>Apakah Anda yakin batal memesan {{ $order->product->nama }} ???</strong></p>
                    </div>

                </div>

                <div class="modal-footer">
                    <form action="{{ route('order.destroy',$order) }}" method="POST" >
                        @csrf @method('delete')
                        <button type="submit" class="btn btn-white">Yakin</button>
                    </form>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tidak</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const baseUrl = $('meta[name="base-url"]').attr('content');
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

            $('#input-permintaan').on('keyup', function(){
                let totalHarga = $(this).val() * {{ $order->product->harga }};
                $('#total-harga').html('Rp. '+ totalHarga);
            });

            $('#input-permintaan').on('change', function(){
                let totalHarga = $(this).val() * {{ $order->product->harga }};
                $('#total-harga').html('Rp. '+ totalHarga);
            });

            const inputBuktiTransfer = document.getElementById("input-bukti-transfer");
            $('#btn-upload').on('click', function(){
                inputBuktiTransfer.click();
            });

            $("#alert").hide();

            inputBuktiTransfer.onchange = function () {
                if (this.files && this.files[0]) {
                    const buktiTransfer = inputBuktiTransfer.files[0];
                    const id = $(this).data('id');
                    let formData = new FormData();
                    let oFReader = new FileReader();
                    formData.append("bukti_transfer", this.files[0]);
                    formData.append("_token", csrfToken);
                    oFReader.readAsDataURL(buktiTransfer);
                    $.ajax({
                        url: baseUrl + "/order/update-bukti-transfer/" + id,
                        method: 'post',
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $('#img-bukti-transfer').attr('src',baseUrl + '/img/loading.gif');
                            $(".close").click();
                        },
                        success:function(data){
                            if (data.error) {
                                $("#card").prepend(`
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                        <span class="alert-text">
                                            <strong>Gagal</strong>
                                            `+ data.message +`
                                        </span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                `);
                                let path = data.bukti_transfer;
                                if (path != 'noimage.jpg') {
                                    path = path.substring(6);
                                }
                                $('#img-bukti-transfer').attr('src',baseUrl + '/storage' + path);
                            } else {
                                $("#card").prepend(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                        <span class="alert-text">
                                            <strong>Berhasil</strong>
                                            `+ data.message +`
                                        </span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                `);
                                let path = data.bukti_transfer;
                                $('#img-bukti-transfer').attr('src',baseUrl + '/storage' + path.substring(6));
                            }
                        },
                    });
                }
            };
        });
    </script>
@endpush
