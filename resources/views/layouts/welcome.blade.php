<!--

=========================================================
* Argon Dashboard - v1.1.2
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2020 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title')
    </title>
    <!-- Favicon -->
    <link href="{{ url('') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ url('') }}/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
    <link href="{{ url('') }}/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ url('') }}/css/argon-dashboard.css?v=1.1.2" rel="stylesheet" />
</head>

<body class="bg-default">
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
            <div class="container px-4">
                <a class="navbar-brand" href="{{ url('') }}">
                    <h1 class="text-white"><b>UD. Special</b></h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-collapse-main">
                    <!-- Collapse header -->
                    <div class="navbar-collapse-header d-md-none">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="{{ url('') }}">
                                    <h1 class="text-primary"><b>UD. Special</b></h1>
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse"
                                    data-target="#navbar-collapse-main" aria-controls="sidenav-main"
                                    aria-expanded="false" aria-label="Toggle sidenav">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Navbar items -->
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('register') }}">
                                    <i class="ni ni-circle-08"></i>
                                    <span class="nav-link-inner--text">Daftar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('login') }}">
                                    <i class="ni ni-key-25"></i>
                                    <span class="nav-link-inner--text">Masuk</span>
                                </a>
                            </li>
                        @else
                            @can('isKepala')
                                <li class="nav-item">
                                    <a class="nav-link nav-link-icon" href="{{ route('dashboard') }}">
                                        <i class="ni ni-planet"></i>
                                        <span class="nav-link-inner--text">Dashboard</span>
                                    </a>
                                </li>
                            @endcan
                            @can('isProdusen')
                                <li class="nav-item">
                                    <a class="nav-link nav-link-icon" href="{{ route('product.index') }}">
                                        <i class="ni ni-app"></i>
                                        <span class="nav-link-inner--text">Manajemen Produk</span>
                                    </a>
                                </li>
                            @endcan
                            @can('isDistributor')
                                <li class="nav-item">
                                    <a class="nav-link nav-link-icon" href="{{ route('belanja') }}">
                                        <i class="ni ni-basket"></i>
                                        <span class="nav-link-inner--text">Belanja</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-link-icon" href="{{ route('order.index') }}">
                                        <i class="fas fa-receipt"></i>
                                        <span class="nav-link-inner--text">Pesanan Saya</span>
                                    </a>
                                </li>
                            @endcan
                            @can('isSuperadmin')
                                <li class="nav-item">
                                    <a class="nav-link nav-link-icon" href="{{ route('users.index') }}">
                                        <i class="ni ni-circle-08"></i>
                                        <span class="nav-link-inner--text">Manajemen Pengguna</span>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('profil') }}">
                                    <i class="ni ni-single-02"></i>
                                    <span class="nav-link-inner--text">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ni ni-user-run"></i>
                                    <span class="nav-link-inner--text">Keluar</span>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            @yield('header')
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            @yield('content')
        </div>
        <footer class="py-5">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            © {{ date('Y') }} <a href="{{ url('') }}" class="font-weight-bold ml-1"
                                target="_blank">{{ config('app.name') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--   Core   -->
    <script src="{{ url('') }}/js/plugins/jquery/dist/jquery.min.js"></script>
    <script src="{{ url('') }}/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--   Optional JS   -->
    <!--   Argon JS   -->
    <script src="{{ url('') }}/js/argon-dashboard.min.js?v=1.1.2"></script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });

    </script>
</body>

</html>
