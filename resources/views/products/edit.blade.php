@extends('layouts.app')

@section('title')
Detail Produk {{ $product->nama }}
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
                        <h2 class="mb-0">UBAH PRODUK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-xl-3 order-xl-2 mb-5 mb-xl-0">
        <div class="card card-profile shadow">
            <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                            <img id="avatar" src="{{asset(Storage::url($product->foto))}}" alt="{{asset(Storage::url($product->foto))}}" class="rounded-circle" style="max-height: 150px; max-width: 200px">
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
                        {{ $product->nama }}
                    </h3>
                    <div class="h5 font-weight-300">
                        Rp. {{ $product->harga }} / {{ $product->satuan }}
                    </div>
                    @if ($product->persediaan)
                        <div class="h5 mt-4">
                            Persediaan : {{ $product->persediaan }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 order-xl-1">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">Ubah Produk {{ $product->nama }}</h3>
            </div>
            <div class="card-body">
                @include('layouts.components.alert')
                <form method="POST" action="{{ route('product.update',$product) }}">
                    @csrf @method('patch')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-nama">Nama</label>
                                <input name="nama" type="text" id="input-nama" class="form-control form-control-alternative @error('nama') is-invalid @enderror" placeholder="Masukkan nama ..." value="{{ old('nama',$product->nama) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-harga">Harga</label>
                                <input name="harga" onkeypress="return hanyaAngka(event)" id="input-harga" class="form-control form-control-alternative @error('harga') is-invalid @enderror" placeholder="Masukkan harga ..." value="{{ old('harga',$product->harga) }}" type="text">
                                @error('harga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-satuan">Satuan</label>
                                <input name="satuan" id="input-satuan" class="form-control form-control-alternative @error('satuan') is-invalid @enderror" placeholder="Masukkan satuan ..." value="{{ old('satuan',$product->satuan) }}" type="text">
                                @error('satuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-persediaan">Persediaan</label>
                                <input name="persediaan" type="number" onkeypress="return hanyaAngka(event)" id="input-persediaan" class="form-control form-control-alternative @error('persediaan') is-invalid @enderror" placeholder="Masukkan persediaan ..." value="{{ old('persediaan',$product->persediaan) }}">
                                @error('persediaan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" onkeypress="return hanyaAngka(event)" for="input-minimal_permintaan">Minimal Permintaan</label>
                                <input name="minimal_permintaan" type="number" id="input-minimal_permintaan" class="form-control form-control-alternative @error('minimal_permintaan') is-invalid @enderror" placeholder="Masukkan minimal_permintaan ..." value="{{ old('minimal_permintaan',$product->minimal_permintaan) }}">
                                @error('minimal_permintaan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('product.show',$product) }}" class="btn btn-block btn-light">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-danger">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-delete">Hapus Produk?</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="py-3 text-center">
                    <i class="ni ni-bell-55 ni-3x"></i>
                    <h4 class="heading mt-4">Perhatian!!</h4>
                    <p>Menghapus Produk akan menghapus semua data yang dimilikinya</p>
                    <p><strong>Apakah Anda yakin ingin menghapus {{ $product->nama }} ???</strong></p>
                </div>

            </div>

            <div class="modal-footer">
                <form action="{{ route('product.destroy',$product) }}" method="POST" >
                    @csrf @method('delete')
                    <button type="submit" class="btn btn-white">Yakin</button>
                </form>
                <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tidak</button>
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

<input type="file" name="avatar" id="input-avatar" data-id="{{ $product->id }}" style="display: none">
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

            inputAvatar.onchange = function () {
                if (this.files && this.files[0]) {
                    const avatar = inputAvatar.files[0];
                    let formData = new FormData();
                    let oFReader = new FileReader();
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    const baseUrl = $('meta[name="base-url"]').attr('content');
                    const id = $(this).data('id');
                    const ext = this.files[0].name.split('.').pop().toLowerCase();
                    formData.append("foto", this.files[0]);
                    formData.append("_token", csrfToken);
                    oFReader.readAsDataURL(avatar);
                    let fsize = avatar.size||avatar.fileSize;
                    if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1) {
                        alert("File harus berupa gambar yang memiliki ekstensi (png, jpg, jpeg)");
                    } else {
                        if(fsize > 2000000) {
                            alert("Ukuran gambar terlalu besar. Max 2mb");
                        }
                        else {
                            $.ajax({
                                url: baseUrl + "/product/update-foto/" + id,
                                method: 'post',
                                data: formData,
                                contentType: false,
                                cache: false,
                                processData: false,
                                beforeSend:function(){
                                    img.src = baseUrl + '/img/loading.gif';
                                },
                                success:function(data){
                                    window.location.href = baseUrl + '/product/' + id + '/edit' ;
                                }
                            });
                        }
                    }
                }
            };
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endpush
