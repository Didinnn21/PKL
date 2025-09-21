<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Kestore.id</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    <style>

        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
            font-family: 'Poppins', sans-serif;
        }

        .form-label {
            color: #ccc;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            background-color: #333;
            border: 1px solid #555;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #333;
            border-color: #d4af37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: #888;
            opacity: 1;
        }

        .btn-warning {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #1a1a1a;
            font-weight: 600;
        }

        .btn-warning:hover {
            background-color: #b39330;
            border-color: #b39330;
            color: #1a1a1a;
        }

        .navbar-top {
            background-color: #252525;
            border-bottom: 1px solid #333;
        }

        .navbar-brand,
        .nav-link,
        .navbar-text {
            color: #d4af37 !important;
            font-weight: 600;
        }

        .sidebar {
            background-color: #252525;
            min-height: 100vh;
            border-right: 1px solid #333;
        }

        .sidebar .nav-link {
            color: #ccc;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link i.nav-icon {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #333;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #1a1a1a;
            border-left-color: #d4af37;
        }

        .sidebar .dropdown-toggle::after {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .sidebar .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(90deg);
        }

        .sidebar .nav-dropdown {
            padding-left: 20px;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-dropdown .nav-link {
            padding-left: 1.5rem;
            border-left: none;
        }

        .sidebar .nav-dropdown .nav-link.active {
            background-color: #333;
            border-radius: 5px;
        }

        main {
            padding: 2rem;
        }

        .logout-form .btn-logout {
            background: none;
            border: none;
            color: #d4af37 !important;
            font-weight: 600;
            padding: 0.5rem 1rem;
            text-align: left;
        }

        .card {
            background-color: #2c2c2c;
            border: 1px solid #444;
        }

        .card-header {
            background-color: #d4af37;
            border-bottom: 1px solid #faf6f6;
        }

        .nav-tabs .nav-link {
            color: #ccc;
            background: none;
            border-color: #333 #333 #444;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #2c2c2c;
            border-color: #444 #444 #2c2c2c;
        }

        .table-dark-custom {
            background-color: #2c2c2c;
            color: #f0f0f0;
        }

        .table-dark-custom th {
            background-color: #333;
            border-color: #444 !important;
            color: #ccc;
        }

        .table-dark-custom td,
        .table-dark-custom th {
            border-color: #444 !important;
        }

        .badge {
            font-weight: 600;
        }

        /* PERBAIKAN KHUSUS UNTUK HALAMAN LAPORAN */
        .list-group-item {
            background-color: transparent !important;
            color: #f0f0f0 !important;
            border-color: #444 !important;
        }

        .badge.bg-warning {
            color: #f8f4f4 !important;
            /* Memastikan teks pada badge kuning dapat dibaca */
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin/dashboard') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo"
                        style="height: 30px; margin-right: 10px;">
                    KESTORE.ID
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @auth
                            <li class="nav-item"><span class="navbar-text">Halo, {{ Auth::user()->name }}</span></li>
                            <li class="nav-item ms-3">
                                <form id="logout-form" class="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-logout">Logout</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt nav-icon"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                    href="#products-submenu" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}">
                                    <i class="fas fa-box-open nav-icon"></i> Produk
                                </a>
                                <div class="collapse nav-dropdown {{ request()->routeIs('admin.products.*') ? 'show' : '' }}"
                                    id="products-submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                                                href="{{ route('admin.products.index') }}"><i
                                                    class="fas fa-list nav-icon"></i> Semua Produk</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                                                href="{{ route('admin.products.create') }}"><i
                                                    class="fas fa-plus nav-icon"></i> Tambah Produk</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                                    href="{{ route('admin.orders.index') }}">
                                    <i class="fas fa-shopping-cart nav-icon"></i> Pesanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                                    href="{{ route('admin.customers.index') }}">
                                    <i class="fas fa-users nav-icon"></i> Data Pembeli
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"
                                    href="{{ route('admin.laporan.penjualan') }}">
                                    <i class="fas fa-chart-pie nav-icon"></i> Laporan
                                </a>
                            </li>
                            <li class="nav-item mt-3 border-top pt-3 border-secondary">
                                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                                    href="{{ route('admin.settings.index') }}">
                                    <i class="fas fa-cog nav-icon"></i> Pengaturan
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
