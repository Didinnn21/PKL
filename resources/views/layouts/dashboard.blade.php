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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --dark-bg: #1a1a1a;
            --dark-surface: #252525;
            --dark-surface-2: #2c2c2c;
            --dark-border: #444;
            --primary-gold: #d4af37;
            --primary-gold-hover: #b39330;
            --text-light: #f0f0f0;
            --text-muted: #b0b0b0; /* Abu yang lebih terang agar terbaca */
        }

        /* --- LAYOUT FIX --- */
        html, body {
            height: 100%;
            overflow: hidden;
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        #app {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar-top {
            flex-shrink: 0;
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
            z-index: 1030;
        }
        .navbar-toggler {
            border-color: var(--text-muted); /* Border toggle terlihat */
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(212, 175, 55, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            /* Ikon hamburger warna Emas */
        }

        /* Content Wrapper */
        .content-wrapper {
            flex: 1;
            overflow: hidden;
            display: flex;
        }
        .layout-row { width: 100%; margin: 0; height: 100%; }

        /* Sidebar */
        .sidebar-container {
            background-color: var(--dark-surface);
            border-right: 1px solid var(--dark-border);
            height: 100%;
            overflow-y: auto;
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        .nav-link {
            color: var(--text-muted) !important; /* Paksa warna teks */
            padding: 0.85rem 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .nav-link i.nav-icon {
            width: 24px;
            margin-right: 12px;
            text-align: center;
            color: var(--text-muted); /* Warna Ikon Default */
            transition: color 0.2s;
        }

        /* Hover Sidebar */
        .nav-link:hover {
            color: #fff !important;
            background-color: var(--dark-surface-2);
        }
        .nav-link:hover i.nav-icon {
            color: var(--primary-gold); /* Ikon jadi Emas saat hover */
        }

        /* Active Sidebar */
        .nav-link.active {
            color: #fff !important;
            background-color: var(--dark-bg);
            border-left-color: var(--primary-gold);
            font-weight: 600;
        }
        .nav-link.active i.nav-icon {
            color: var(--primary-gold); /* Ikon Emas saat aktif */
        }

        /* Main Content */
        .main-content {
            background-color: var(--dark-bg);
            height: 100%;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Form Styling */
        .form-label { color: var(--text-muted) !important; font-weight: 500; }
        .form-control, .form-select {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            color: #fff !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--dark-surface-2);
            border-color: var(--primary-gold);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        .form-control::placeholder { color: #888 !important; opacity: 1; }

        /* Card & Table */
        .card { background-color: var(--dark-surface-2); border: 1px solid var(--dark-border); border-radius: 12px; }
        .card-header { background-color: var(--dark-surface); border-bottom: 1px solid var(--dark-border); font-weight: 600; color: var(--text-light); }

        .table { color: var(--text-light); }
        thead th { color: var(--primary-gold) !important; border-bottom-width: 1px !important; border-color: var(--dark-border) !important; }
        tbody td, tbody th { border-color: var(--dark-border) !important; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--dark-bg); }
        ::-webkit-scrollbar-thumb { background: #444; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-gold); }

        /* Logout Button */
        .btn-logout { background: none; border: none; color: var(--primary-gold) !important; font-weight: 600; padding: 0.5rem 1rem; transition: color 0.2s ease; }
        .btn-logout:hover { color: #fff !important; }
        .navbar-brand { color: var(--primary-gold) !important; font-weight: 700; }
        .navbar-text { color: var(--text-muted) !important; }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Logo" style="height: 30px; margin-right: 10px;">
                    ADMIN KESTORE.ID
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @auth
                            <li class="nav-item"><span class="navbar-text me-3">Halo, {{ Auth::user()->name }}</span></li>
                            <li class="nav-item">
                                <form id="logout-form" class="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid content-wrapper p-0">
            <div class="row layout-row g-0">

                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block collapse p-0 h-100">
                    <div class="sidebar-container">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt nav-icon"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                    <i class="fas fa-box-open nav-icon"></i> Produk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                    <i class="fas fa-shopping-cart nav-icon"></i> Pesanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                                    <i class="fas fa-users nav-icon"></i> Data Pembeli
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.shippings.*') ? 'active' : '' }}" href="{{ route('admin.shippings.index') }}">
                                    <i class="fas fa-truck nav-icon"></i> Jasa Kirim
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="{{ route('admin.laporan.penjualan') }}">
                                    <i class="fas fa-chart-pie nav-icon"></i> Laporan
                                </a>
                            </li>
                            <li class="nav-item mt-3 border-top border-secondary pt-3">
                                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                    <i class="fas fa-cog nav-icon"></i> Pengaturan
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 p-0 h-100">
                    <div class="main-content">
                        @yield('content')
                    </div>
                </main>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')
</body>

</html>
