@extends('layouts.app')

@section('title')
Profil Pengguna
@endsection

@section('content-header')
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
    style="min-height: 600px; background-image: url({{asset(Storage::url(Auth::user()->avatar))}}); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-7 col-md-10">
                <h1 class="display-2 text-white">Hello {{ Auth::user()->nama }}</h1>
                @if (Auth::user()->tentang_saya)
                    <p class="text-white mt-0 mb-5">{{ Auth::user()->tentang_saya }}</p>
                @endif
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
                            <img src="{{asset(Storage::url(Auth::user()->avatar))}}" class="rounded-circle">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">

            </div>
            <div class="card-body pt-0 pt-md-4 mt-5">
                <div class="text-center">
                    <h3>
                        {{ Auth::user()->nama }}
                    </h3>
                    <div class="h5 font-weight-300">
                        {{ Auth::user()->email }}
                    </div>
                    @if (Auth::user()->nomor_hp)
                        <div class="h5 mt-4">
                            Nomor Hp : {{ Auth::user()->nomor_hp }}
                        </div>
                    @endif
                    @if (Auth::user()->alamat)
                        <hr class="my-4" />
                        <p>Alamat : {{ Auth::user()->alamat }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Akun Saya</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="#!" class="btn btn-sm btn-primary">Pengaturan</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-nama">Nama</label>
                                    <input type="text" id="input-nama" class="form-control form-control-alternative"
                                        placeholder="nama" value="{{ Auth::user()->nama }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">Email</label>
                                    <input type="email" id="input-email" class="form-control form-control-alternative"
                                        placeholder="{{ Auth::user()->email }}">
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
                            <input id="input-alamat" class="form-control form-control-alternative"
                                placeholder="Alamat"
                                value="{{ Auth::user()->alamat }}" type="text">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-nomor-hp">Nomor Hp</label>
                            <input id="input-nomor-hp" class="form-control form-control-alternative"
                                placeholder="Nomor Hp"
                                value="{{ Auth::user()->nomor_hp }}" type="text">
                        </div>
                    </div>
                    <hr class="my-4" />
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">Tentang Saya</h6>
                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label>Tentang Saya</label>
                            <textarea rows="4" class="form-control form-control-alternative"
                                placeholder="Beberapa kata tentang anda ...">{{ Auth::user()->tentang_saya }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
