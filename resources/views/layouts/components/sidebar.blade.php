<div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
        aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Brand -->
    <a class="navbar-brand pt-0" href="{{ route('home') }}">
        <h1 class="text-primary"><b>{{ config('app.name') }}</b></h1>
    </a>
    <!-- User -->
    <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
            <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ni ni-bell-55"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right"
                aria-labelledby="navbar-default_dropdown_1">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle">
                        <img alt="{{ asset(Storage::url(Auth::user()->avatar)) }}" src="{{ asset(Storage::url(Auth::user()->avatar)) }}">
                    </span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                <a href="{{ route('profil') }}"  class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ url('') }}"  class="dropdown-item">
                    <i class="ni ni-settings-gear-65"></i>
                    <span>Pengaturan</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </li>
    </ul>
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
            <div class="row">
                <div class="col-6 collapse-brand">
                    <a href="{{ route('home') }}">
                        <h1 class="text-primary"><b>{{ config('app.name') }}</b></h1>
                    </a>
                </div>
                <div class="col-6 collapse-close">
                    <button type="button" class="navbar-toggler" data-toggle="collapse"
                        data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                        aria-label="Toggle sidenav">
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
            <div class="input-group input-group-rounded input-group-merge">
                <input type="search" class="form-control form-control-rounded form-control-prepended"
                    placeholder="Search" aria-label="Search">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-search"></span>
                    </div>
                </div>
            </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
            @can('isPemilik')
                <li class="nav-item">
                    @if (Request::segment(1) == 'dasboard')
                        <a class="nav-link active" href="{{ route('dasboard') }}">
                    @else
                        <a class="nav-link" href="{{ route('dasboard') }}">
                    @endif
                        <i class="ni ni-planet text-blue"></i>
                        <span class="nav-link-inner--text">Dashboard</span>
                    </a>
                </li>
            @endcan
            @can('isProdusen')
                <li class="nav-item">
                    @if (Request::segment(1) == 'products')
                        <a class="nav-link active" href="{{ url('products') }}">
                    @else
                        <a class="nav-link" href="{{ url('products') }}">
                    @endif
                        <i class="ni ni-app text-blue"></i>
                        <span class="nav-link-inner--text">Manajemen Produk</span>
                    </a>
                </li>
            @endcan
            @can('isDistributor')
                <li class="nav-item">
                    @if (Request::segment(1) == 'orders')
                        <a class="nav-link active" href="{{ url('orders') }}">
                    @else
                        <a class="nav-link" href="{{ url('orders') }}">
                    @endif
                        <i class="ni ni-basket text-blue"></i>
                        <span class="nav-link-inner--text">Beli Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    @if (Request::segment(1) == 'pesanan')
                        <a class="nav-link active" href="{{ url('pesanan') }}">
                    @else
                        <a class="nav-link text-orange" href="{{ url('pesanan') }}">
                    @endif
                        <i class="ni ni-email-83"></i>
                        <span class="nav-link-inner--text">Pesanan</span>
                    </a>
                </li>
            @endcan
            @can('isSuperadmin')
                <li class="nav-item">
                    @if (Request::segment(1) == 'users')
                        <a class="nav-link active" href="{{ route('users.index') }}">
                    @else
                        <a class="nav-link" href="{{ route('users.index') }}">
                    @endif
                        <i class="ni ni-circle-08 text-blue"></i>
                        <span class="nav-link-inner--text">Manajemen Pengguna</span>
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                @if (Request::segment(1) == 'profil')
                    <a class="nav-link active" href="{{ route('profil') }}">
                @else
                    <a class="nav-link" href="{{ route('profil') }}">
                @endif
                    <i class="ni ni-single-02 text-yellow"></i> User profile
                </a>
            </li>
        </ul>
    </div>
</div>
