@extends('layouts.app')

@section('title')
Manajemen Pengguna
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection

@section('form-search-mobile')
<form form action="{{ route('users.cari') }}" method="GET" class="mt-4 mb-3 d-md-none">
    <div class="input-group input-group-rounded input-group-merge">
        <input name="cari" type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Cari ..." aria-label="Search" {{ request('cari') }}>
        <div class="input-group-prepend">
            <div class="input-group-text">
                <span class="fa fa-search"></span>
            </div>
        </div>
    </div>
</form>
@endsection

@section('form-search')
    <form action="{{ route('users.cari') }}" method="GET" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input name="cari" class="form-control" placeholder="Cari ..." type="text" value="{{ request('cari') }}">
            </div>
        </div>
    </form>
@endsection

@section('content-header')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Pengguna</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $totalUser }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Distributor</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $totalDistributor }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Dark table -->
<div class="row">
    <div class="col">
        <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0 text-white">Daftar Pengguna</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus" title="Tambah Pengguna"></i></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-dark table-flush">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nomor Hp</th>
                            <th scope="col">Peran</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <a href="#" class="avatar rounded-circle">
                                            <img class="img-foto" alt="{{ asset(Storage::url($user->avatar)) }}" src="{{ asset(Storage::url($user->avatar)) }}">
                                        </a>
                                    </div>
                                </th>
                                <td>
                                    <a href="{{ route("users.show",$user) }}">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    {{ $user->nama }}
                                </td>
                                <td>
                                    @if ($user->nomor_hp)
                                        {{ $user->nomor_hp }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $user->role->peran }}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('users.show',$user) }}"><i class="fas fa-fw fa-eye"></i>Detail</a>
                                            <a class="dropdown-item" href="{{ route('users.edit',$user) }}"><i class="fas fa-fw fa-edit"></i>Ubah</a>
                                            <a class="dropdown-item hapus" data-nama="{{ $user->nama }}" data-id="{{ $user->id }}" data-toggle="modal" href="#modal-delete"><i class="fas fa-fw fa-trash"></i>Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-0 py-4">
                <nav aria-label="...">
                    {{ $users->links() }}
                </nav>
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
                    <p><strong id="nama-hapus"></strong></p>
                </div>

            </div>

            <div class="modal-footer">
                <form id="form-hapus" action="" method="POST" >
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
        $(document).ready(function(){
            const baseUrl = $('meta[name="base-url"]').attr('content');

            // Get the modal
            const modal = document.getElementById("foto-profil");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            const img = document.querySelectorAll('.img-foto');
            const modalImg = document.getElementById("img01");
            for (let index = 0; index < img.length; index++) {
                img[index].onclick = function(){
                    modal.style.display = "block";
                    modalImg.src = this.src;
                };
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

            $('.hapus').on('click', function(){
                $('#nama-hapus').html('Apakah Anda yakin ingin menghapus ' + $(this).data('nama') + '???');
                $('#form-hapus').attr('action', baseUrl + '/users/' + $(this).data('id'));
            });

        });

    </script>
@endpush
