@extends('layouts.welcome')

@section('title')
    {{ config('app.name') }} - Masuk
@endsection

@section('header')
    <h1 class="text-white">Masuk</h1>
    <p class="text-lead text-light">Silahkan Masuk Terlebih Dahulu</p>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
        <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">
                <div class="text-muted text-center mt-2 mb-3"><small>Masuk dengan</small></div>
                <div class="btn-wrapper text-center">
                    <a href="#" class="btn btn-neutral btn-icon">
                        <span class="btn-inner--icon"><img src="{{ url('') }}/img/icons/common/google.svg"></span>
                        <span class="btn-inner--text">Google</span>
                    </a>
                </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                    <small>Atau masuk dengan kredensial</small>
                </div>
                <form role="form" action="{{ route('login') }}" method="POST" >
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" type="email">
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
                    <div class="custom-control custom-control-alternative custom-checkbox">
                        <input class="custom-control-input" id=" customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }} name="remember">
                        <label class="custom-control-label" for=" customCheckLogin">
                            <span class="text-muted">Ingat saya</span>
                        </label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary my-4">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <a href="{{ route('password.request') }}" class="text-light"><small>Lupa password?</small></a>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('register') }}" class="text-light"><small>Buat akun baru</small></a>
            </div>
        </div>
    </div>
</div>
@endsection
