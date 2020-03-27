<div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
        aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Brand -->
    <a class="navbar-brand pt-0" href="{{ route('home') }}">
        <h1 class="text-primary font-weight-900">{{ config('app.name') }}</h1>
    </a>
    <!-- User -->
    <ul class="nav align-items-center d-md-none">
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
        @yield('form-search-mobile')
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
                    @if (Request::segment(1) == 'product')
                        <a class="nav-link active" href="{{ route('product.index') }}">
                    @else
                        <a class="nav-link" href="{{ route('product.index') }}">
                    @endif
                        <i class="ni ni-app text-blue"></i>
                        <span class="nav-link-inner--text">Manajemen Produk</span>
                    </a>
                </li>
            @endcan
            @can('isDistributor')
                <li class="nav-item">
                    @if (Request::segment(1) == 'belanja')
                        <a class="nav-link active" href="{{ route('belanja') }}">
                    @else
                        <a class="nav-link" href="{{ route('belanja') }}">
                    @endif
                        <i class="ni ni-basket text-primary"></i>
                        <span class="nav-link-inner--text">Belanja</span>
                    </a>
                </li>
                <li class="nav-item">
                    @if (Request::segment(1) == 'order')
                        <a class="nav-link active" href="{{ route('order.index') }}">
                    @else
                        <a class="nav-link" href="{{ route('order.index') }}">
                    @endif
                        <i class="fas fa-receipt text-green"></i>
                        <span class="nav-link-inner--text">Pesanan Saya</span>
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
                        <i class="fas fa-users text-blue"></i>
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
                    <i class="ni ni-single-02 text-yellow"></i> Profil Saya
                </a>
            </li>
        </ul>
        <hr class="my-3">
        <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run"></i> Keluar
                </a>
            </li>
        </ul>
    </div>
</div>
