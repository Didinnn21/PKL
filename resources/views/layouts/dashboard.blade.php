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

    {{-- PENAMBAHAN: CSS untuk DataTables agar tabel menjadi interaktif --}}
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
            --text-muted: #a0a0a0;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Atas */
        .navbar-top {
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
        }

        .navbar-brand {
            color: var(--primary-gold) !important;
            font-weight: 700;
        }

        .navbar-text {
            color: var(--text-muted) !important;
        }

        .logout-form .btn-logout {
            background: none;
            border: none;
            color: var(--primary-gold) !important;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: color 0.2s ease;
        }

        .logout-form .btn-logout:hover {
            color: #fff !important;
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--dark-surface);
            min-height: 100vh;
            border-right: 1px solid var(--dark-border);
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 0.85rem 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link i.nav-icon {
            width: 20px;
            margin-right: 15px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: var(--dark-surface-2);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--dark-bg);
            border-left-color: var(--primary-gold);
            font-weight: 600;
        }

        /* Konten Utama */
        main {
            padding: 2rem;
        }

        .page-header {
            border-bottom: 1px solid var(--dark-border);
        }

        /* Styling Umum untuk Komponen */
        .card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
        }

        .card-header {
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
            font-weight: 600;
            color: var(--text-light);
        }

        .table {
            color: var(--text-light);
        }

        .table-hover tbody tr:hover {
            background-color: var(--dark-surface);
            color: #fff;
        }

        thead th {
            color: var(--text-muted);
            border-bottom-width: 1px !important;
            border-color: var(--dark-border) !important;
        }

        tbody td,
        tbody th {
            border-color: var(--dark-border) !important;
        }

        /* PENAMBAHAN: Styling agar DataTables menyatu dengan tema gelap */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--dark-surface-2);
            color: var(--text-light);
            border: 1px solid var(--dark-border);
            border-radius: 6px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-link {
            background-color: transparent;
            border: 1px solid transparent;
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
            color: var(--dark-bg) !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-item:not(.active) .page-link:hover {
            background-color: var(--dark-surface);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-top shadow-sm sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo"
                        style="height: 30px; margin-right: 10px;">
                    ADMIN KESTORE.ID
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @auth
                            <li class="nav-item"><span class="navbar-text me-3">Halo, {{ Auth::user()->name }}</span></li>
                            <li class="nav-item">
                                <form id="logout-form" class="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-logout"><i
                                            class="fas fa-sign-out-alt me-2"></i>Logout</button>
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
                                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                    href="{{ route('admin.products.index') }}">
                                    <i class="fas fa-box-open nav-icon"></i> Produk
                                </a>
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

    {{-- PENAMBAHAN: Library JavaScript untuk fungsionalitas tambahan --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>

</html>
