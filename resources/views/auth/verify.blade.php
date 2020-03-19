@extends('layouts.welcome')

@section('title')
    {{ config('app.name') }} - Verifikasi Email
@endsection

@section('header')
    <h1>Verifikasi Email Anda</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.verify_resent') }}
                        </div>
                    @endif

                    {{ __('auth.verify_email_check') }}
                    {{ __('auth.verify_not_receive_email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.verify_resent_email') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
