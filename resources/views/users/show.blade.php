@extends('layouts.app')

@section('title')
Detail Pengguna
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection

@section('content-header')

<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url({{ asset('/img/cover-bg-profil.jpg') }}); background-size: cover; background-position: center top;">

    <!-- Mask -->
    <span class="mask bg-gradient-primary opacity-6"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">

        <div class="row">
            <div class="col-lg-7 col-md-10">
                <h1 class="display-2 text-white">Hello {{ $user->nama }}</h1>
                @if ($user->tentang_saya)
                    <p class="text-white mt-0 mb-5">{{ $user->tentang_saya }}</p>
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
                            <img id="avatar" src="{{asset(Storage::url($user->avatar))}}" alt="{{asset(Storage::url($user->avatar))}}" class="rounded-circle" style="max-height: 150px; max-width: 200px">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 mb-5 pt-md-4 pb-0 pb-md-4">
            </div>
            <div class="card-body pt-0 pt-md-4 pt-5">
                <div class="text-center">
                    <h3>
                        {{ $user->nama }}
                    </h3>
                    <div class="h5 font-weight-300">
                        {{ $user->email }}
                    </div>
                    @if ($user->nomor_hp)
                        <div class="h5 mt-4">
                            Nomor Hp : {{ $user->nomor_hp }}
                        </div>
                    @endif
                    @if ($user->alamat)
                        <hr class="my-4" />
                        <p>Alamat : {{ $user->alamat }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row">
                    <div class="col-8">
                        <h3 class="mb-0">Akun {{ $user->nama }}</h3>
                    </div>
                    <div class="col-4 text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only" href="#" role="button" title="Option"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="{{ route('users.edit',$user) }}"><i class="fas fa-fw fa-edit"></i>Ubah</a>
                                <a class="dropdown-item" data-toggle="modal" href="#modal-delete"><i class="fas fa-fw fa-trash"></i>Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-nama">Nama</label>
                                <input disabled type="text" id="input-nama" class="form-control form-control-alternative" placeholder="nama" value="{{ $user->nama }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">Email</a></label>
                                <input disabled type="email" id="input-email" class="form-control form-control-alternative" placeholder="{{ $user->email }}">
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
                        <input disabled id="input-alamat" class="form-control form-control-alternative" placeholder="Alamat" value="{{ $user->alamat }}" type="text">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-nomor-hp">Nomor Hp</label>
                        <input disabled id="input-nomor-hp" class="form-control form-control-alternative" placeholder="Nomor Hp" value="{{ $user->nomor_hp }}" type="text">
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">Tentang Saya</h6>
                <div class="pl-lg-4">
                    <div class="form-group">
                        <label>Tentang Saya</label>
                        <textarea disabled rows="4" class="form-control form-control-alternative" placeholder="Beberapa kata tentang anda ...">{{ $user->tentang_saya }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="foto-profil" class="modal-full">
    <!-- The Close Button -->
    <span class="tutup">&times;</span>
    <!-- Modal Content (The Image) -->
    <div class="container">
        <img class="image-zoom mw-100 img-center" id="img01">
    </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-danger">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-delete">Hapus Pengguna?</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="py-3 text-center">
                    <i class="ni ni-bell-55 ni-3x"></i>
                    <h4 class="heading mt-4">Perhatian!!</h4>
                    <p>Menghapus pengguna akan menghapus semua data yang dimilikinya</p>
                    <p><strong>Apakah Anda yakin ingin menghapus {{ $user->nama }} ???</strong></p>
                </div>

            </div>

            <div class="modal-footer">
                <form action="{{ route('users.destroy',$user) }}" method="POST" >
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
        // Get the modal
        const modal = document.getElementById("foto-profil");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        const img = document.getElementById("avatar");
        const modalImg = document.getElementById("img01");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
        }

        // Get the <span> element that tutups the modal
        const span = document.getElementsByClassName("tutup")[0];

        // When the user clicks on <span> (x), tutup the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        document.addEventListener('keyup',(e) => {
            if(e.key === "Escape") modal.style.display = "none";
        });
    </script>
@endpush
