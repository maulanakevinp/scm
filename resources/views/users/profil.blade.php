@extends('layouts.app')

@section('title')
Profil Pengguna
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
                            <img id="avatar" src="{{asset(Storage::url(Auth::user()->avatar))}}" alt="{{asset(Storage::url(Auth::user()->avatar))}}" class="rounded-circle" style="max-height: 150px; max-width: 200px">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 pt-md-4 pb-0 pb-md-4">
                <a id="btn-ganti-avatar" href="#input-avatar" class="btn btn-sm btn-default mt-5"><span class="fas fa-camera"></span> Ganti</a>
            </div>
            <div class="card-body pt-0 pt-md-4 pt-5">
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
                        <a href="{{ route('pengaturan') }}" class="btn btn-sm btn-primary">Pengaturan</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.components.alert')
                <div class="row">
                    <div class="col-6 h6" id="created-at">
                    </div>
                    <div class="col-6 text-right h6" id="updated-at">
                    </div>
                </div>
                <form action="{{ route('update-profil', Auth::user()) }}" method="POST">
                    @csrf @method('patch')
                    <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-nama">Nama</label>
                                    <input name="nama" type="text" id="input-nama" class="form-control form-control-alternative @error('nama') is-invalid @enderror" placeholder="Masukkan nama ..." value="{{ old('nama',Auth::user()->nama) }}">
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">Email <a href="{{ route('pengaturan') }}" class="badge badge-primary" title="Ganti email"><span class="fas fa-edit"></span></a></label>
                                    <input type="email" id="input-email" class="form-control form-control-alternative" value="{{ Auth::user()->email }}" disabled>
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
                            <input name="alamat" id="input-alamat" class="form-control form-control-alternative" placeholder="Masukkan alamat ..." value="{{ Auth::user()->alamat }}" type="text">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-nomor-hp">Nomor Hp</label>
                            <input name="nomor_hp" onkeypress="return hanyaAngka(event)" id="input-nomor-hp" class="form-control form-control-alternative @error('nomor_hp') is-invalid @enderror" placeholder="Masukkan nomor hp ..." value="{{ old('nomor_hp',Auth::user()->nomor_hp) }}" type="text">
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
                            <textarea name="tentang_saya" rows="4" class="form-control form-control-alternative" placeholder="Beberapa kata tentang anda ...">{{ old('tentang_saya',Auth::user()->tentang_saya) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                </form>
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

<input type="file" name="avatar" id="input-avatar" style="display: none">
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
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

            const btnGantiAvatar = document.getElementById("btn-ganti-avatar");
            const inputAvatar = document.getElementById("input-avatar");
            btnGantiAvatar.onclick = function () {
                inputAvatar.click();
            };

            const baseUrl = $('meta[name="base-url"]').attr('content');
            const id = $('meta[name="auth-id"]').attr('content');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const data = {
                id: id,
                _token: csrfToken,
            };
            inputAvatar.onchange = function () {
                if (this.files && this.files[0]) {
                    const avatar = inputAvatar.files[0];
                    let formData = new FormData();
                    let oFReader = new FileReader();
                    formData.append("avatar", this.files[0]);
                    formData.append("_token", csrfToken);
                    oFReader.readAsDataURL(avatar);
                    let fsize = avatar.size||avatar.fileSize;
                    if(fsize > 2000000) {
                        alert("Ukuran gambar terlalu besar. Max 2mb");
                    }
                    else {
                        $.ajax({
                            url: baseUrl + "/update-avatar/" + id,
                            method: 'post',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend:function(){
                                img.src = baseUrl + '/img/loading.gif';
                            },
                            success:function(data){
                                window.location.href = baseUrl + '/profil';
                                console.log(data);
                            }
                        });
                    }
                }
            };
            setInterval(function(){
                if (navigator.onLine) {
                    $.post(baseUrl + '/users/get-updated-at', data, function(hasil){
                        document.getElementById('updated-at').innerHTML = hasil;
                    });
                    $.post(baseUrl + '/users/get-created-at', data, function(hasil){
                        document.getElementById('created-at').innerHTML = hasil;
                    });
                } else {
                    alert('Harap periksa koneksi internet anda');
                }
            }, 1000);
        });

    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endpush
