@extends('layouts.welcome')

@section('title')
    {{ config('app.name') }} - Kebijakan Privasi
@endsection

@section('header')
    <h1>Kebijakan Privasi</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <ol>
                        <li>Setiap pengguna wajib mengisi secara lengkap profil masing-masing</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
