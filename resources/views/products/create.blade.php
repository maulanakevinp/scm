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
                        <h2 class="mb-0">Tambah Produk</h2>
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
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-avatar">Foto Produk</label><br>
                                <a href="#" title="Tambah Foto Produk">
                                    <img id="img-avatar" src="{{ asset('/img/plus-img.png') }}" alt="{{ asset('/img/plus-img.png') }}" class="rounded-circle border" style="max-height: 150px; max-width: 200px;">
                                </a>
                            </div>
                            <div class="col-lg-6">
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
                            <div class="col-lg-6">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-persediaan">Persediaan</label>
                                    <input name="persediaan" type="number" id="input-persediaan" class="form-control form-control-alternative @error('persediaan') is-invalid @enderror" placeholder="Masukkan persediaan ..." value="{{ old('persediaan') }}">
                                    @error('persediaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <input name="permintaan_min" type="number" id="input-permintaan_min" class="form-control form-control-alternative @error('permintaan_min') is-invalid @enderror" placeholder="Masukkan permintaan minimal ..." value="{{ old('permintaan_min') }}">
                                    @error('permintaan_min')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-permintaan_max">Permintaan Maximal</label>
                                    <input name="permintaan_max" type="number" id="input-permintaan_max" class="form-control form-control-alternative @error('permintaan_max') is-invalid @enderror" placeholder="Masukkan permintaan maximal ..." value="{{ old('permintaan_max') }}">
                                    @error('permintaan_max')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <input name="persediaan_min" type="number" id="input-persediaan_min" class="form-control form-control-alternative @error('persediaan_min') is-invalid @enderror" placeholder="Masukkan persediaan minimal ..." value="{{ old('persediaan_min') }}">
                                    @error('persediaan_min')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-persediaan_max">Persediaan Maximal</label>
                                    <input name="persediaan_max" type="number" id="input-persediaan_max" class="form-control form-control-alternative @error('persediaan_max') is-invalid @enderror" placeholder="Masukkan persediaan maximal ..." value="{{ old('persediaan_max') }}">
                                    @error('persediaan_max')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <input name="produksi_min" type="number" id="input-produksi_min" class="form-control form-control-alternative @error('produksi_min') is-invalid @enderror" placeholder="Masukkan produksi mininimal ..." value="{{ old('produksi_min') }}">
                                    @error('produksi_min')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-produksi_max">Produksi Maximal</label>
                                    <input name="produksi_max" type="number" id="input-produksi_max" class="form-control form-control-alternative @error('produksi_max') is-invalid @enderror" placeholder="Masukkan produksi maximal ..." value="{{ old('produksi_max') }}">
                                    @error('produksi_max')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
