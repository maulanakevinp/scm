@extends('layouts.welcome')

@section('title')
    {{ config('app.name') }} - Konfirmasi Password
@endsection

@section('header')
    <h1>Konfirmasi Password</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    {{ __('Sebelum melanjutkan harap konfirmasi password anda.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

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

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Konfirmasi Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (Route::has('password.request'))
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="{{ route('password.request') }}" class="text-light"><small>Lupa password?</small></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
