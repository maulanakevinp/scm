@extends('layouts.app')

@section('title')
Tambah Pengguna
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
                        <h2 class="mb-0">Tambah Pengguna</h2>
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
                <h3 class="mb-0">Akun Pengguna Baru</h3>
            </div>
            <div class="card-body">
                @include('layouts.components.alert')
                <p class="text-monospace">Tanda <span class="text-red">*</span> = Wajib diisi</p>
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-avatar">Foto Profil</label><br>
                                <a href="#">
                                    <img id="img-avatar" src="{{ asset('/storage/noimage.jpg') }}" alt="{{ asset('/storage/noimage.jpg') }}" class="rounded-circle border" style="max-height: 150px; max-width: 200px;">
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-peran">Peran <span class="text-red">*</span></label>
                                    <select name="peran" id="input-peran" class="form-control form-control-alternative @error('peran') is-invalid @enderror">
                                        <option value="">Pilih</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('peran') == $role->id ? 'selected' : '' }}>{{ $role->peran }}</option>
                                        @endforeach
                                    </select>
                                    @error('peran')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-nama">Nama</label>
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
                                    <label class="form-control-label" for="input-email">Email</a></label>
                                    <input type="email" id="input-email" class="form-control form-control-alternative @error('email') is-invalid @enderror" placeholder="Masukkan email ..." name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">Informasi Kontak</h6>
                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label class="form-control-label" for="input-alamat">Alamat</label>
                            <input name="alamat" id="input-alamat" class="form-control form-control-alternative" placeholder="Masukkan alamat ..." value="{{ old('alamat') }}" type="text">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-nomor-hp">Nomor Hp</label>
                            <input name="nomor_hp" onkeypress="return hanyaAngka(event)" id="input-nomor-hp" class="form-control form-control-alternative @error('nomor_hp') is-invalid @enderror" placeholder="Masukkan nomor hp ..." value="{{ old('nomor_hp') }}" type="text">
                            @error('nomor_hp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <hr class="my-4" />
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">Tentang Saya</h6>
                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label>Tentang Saya</label>
                            <textarea name="tentang_saya" rows="4" class="form-control form-control-alternative" placeholder="Beberapa kata tentang anda ...">{{ old('tentang_saya') }}</textarea>
                        </div>
                    </div>
                    <input type="file" name="avatar" id="input-avatar" style="display: none">

                    <hr class="my-4" />

                    <h6 class="heading-small text-muted mb-4">Password</h6>
                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label class="form-control-label" for="password">Password</label>
                            <input class="form-control form-control-alternative @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Masukkan password" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="password_confirmation">Konfirmasi Password</label>
                            <input class="form-control form-control-alternative @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation" placeholder="Masukkan password" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambahkan Pengguna</button>
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
