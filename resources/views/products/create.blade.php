@extends('layouts.app')

@section('title')
Tambah Produk
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
                        <h2 class="mb-0">TAMBAH PRODUK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">Tambah Produk Baru</h3>
            </div>
            <div class="card-body">
                @include('layouts.components.alert')
                <p class="text-monospace">Tanda <span class="text-red">*</span> = Wajib diisi</p>
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">Informasi Produk</h6>
                    <div class="pl-md-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-control-label" for="input-avatar">Foto Produk</label><br>
                                <a href="#" title="Upload Foto Produk">
                                    <img id="img-avatar" src="{{ asset('/img/plus-img.png') }}" alt="{{ asset('/img/plus-img.png') }}" class="rounded-circle border mw-100" style="max-height: 150px; max-width: 200px;">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-nama">Nama <span class="text-red">*</span></label>
                                            <input name="nama" type="text" id="input-nama" class="form-control form-control-alternative @error('nama') is-invalid @enderror" placeholder="Masukkan nama ..." value="{{ old('nama') }}">
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-persediaan">Persediaan</label>
                                            <input name="persediaan" onkeypress="return hanyaAngka(event)" type="number" id="input-persediaan" class="form-control form-control-alternative @error('persediaan') is-invalid @enderror" placeholder="Masukkan persediaan ..." value="{{ old('persediaan') }}">
                                            @error('persediaan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-harga">Harga <span class="text-red">*</span></label>
                                            <input name="harga" onkeypress="return hanyaAngka(event)" id="input-harga" class="form-control form-control-alternative @error('harga') is-invalid @enderror" placeholder="Masukkan harga ..." value="{{ old('harga') }}" type="text">
                                            @error('harga')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-satuan">Satuan <span class="text-red">*</span></label>
                                            <input name="satuan" id="input-satuan" class="form-control form-control-alternative @error('satuan') is-invalid @enderror" placeholder="Masukkan satuan ..." value="{{ old('satuan') }}" type="text">
                                            @error('satuan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-minimal_permintaan">Minimal Permintaan</label>
                                            <input name="minimal_permintaan" onkeypress="return hanyaAngka(event)" type="number" id="input-minimal_permintaan" class="form-control form-control-alternative @error('minimal_permintaan') is-invalid @enderror" placeholder="Masukkan minimal permintaan ..." value="{{ old('minimal_permintaan') }}">
                                            @error('minimal_permintaan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="foto" id="input-avatar" style="display: none">
                    <button type="submit" class="btn btn-primary btn-block">Tambahkan Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        const imgAvatar = document.getElementById("img-avatar");
        const inputAvatar = document.getElementById("input-avatar");
        imgAvatar.onmouseenter = function(){
            this.style.opacity = "0.5";
        }
        imgAvatar.onmouseleave = function(){
            this.style.opacity = "1";
        }
        imgAvatar.onclick = function () {
            inputAvatar.click();
        };

        inputAvatar.onchange = function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    imgAvatar.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        };
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endpush
