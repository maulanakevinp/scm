@extends('layouts.welcome')

@section('title')
    {{ config('app.name') }} - Daftar
@endsection

@section('header')
    <h1 class="text-white">Daftar</h1>
    <p class="text-lead text-light">Silahkan Daftar Terlebih Dahulu Jika Belum Memiliki Akun</p>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">
                <div class="text-muted text-center mt-2 mb-4"><small>Daftar dengan</small></div>
                <div class="text-center">
                    <a href="#" class="btn btn-neutral btn-icon">
                        <span class="btn-inner--icon"><img src="{{ url('') }}/img/icons/common/google.svg"></span>
                        <span class="btn-inner--text">Google</span>
                    </a>
                </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                    <small>Atau mendaftar dengan kredensial</small>
                </div>
                <form method="POST" action="{{ route('register') }}" role="form">
                    @csrf
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                            </div>
                            <input class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" type="text" name="nama">
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" type="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" type="password" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-12">
                            <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                            <label class="custom-control-label" for="customCheckRegister">
                                <span class="text-muted">Saya setuju dengan <a href="{{route('kebijakan-privasi')}}">Kebijakan Privasi</a></span>
                            </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-4">Buat Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
