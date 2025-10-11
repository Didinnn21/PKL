<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Dashboard') - Kestore.id</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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
            --text-light: #f0f0f0;
            --text-muted: #a0a0a0;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: var(--dark-surface);
            min-height: 100vh;
            border-right: 1px solid var(--dark-border);
        }

        .main-content {
            flex-grow: 1;
        }

        .topnav {
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
            padding: 0.75rem 1.5rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dropdown-menu {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
        }

        .dropdown-item {
            color: var(--text-light);
        }

        .dropdown-item:hover {
            background-color: var(--primary-gold);
            color: var(--dark-bg);
        }

        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--dark-border);
            text-align: center;
        }

        .sidebar-header a {
            color: var(--primary-gold) !important;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 0.9rem 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link i {
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

        .sidebar-heading {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #777;
        }

        .page-content {
            padding: 2rem;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--dark-surface-2);
            color: var(--text-light);
            border: 1px solid var(--dark-border);
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate .page-link {
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-link {
            background-color: transparent;
            border: 1px solid transparent;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
            color: var(--dark-bg) !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('member.dashboard') }}">MEMBER AREA</a>
            </div>
            <ul class="nav flex-column">
                <li class="sidebar-heading">Utama</li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                        href="{{ route('member.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="sidebar-heading">Toko</li>
                <li class="nav-item"><a
                        class="nav-link {{ request()->routeIs('member.products.index') ? 'active' : '' }}"
                        href="{{ route('member.products.index') }}"><i class="fas fa-tshirt"></i> Katalog Produk</a>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('member.orders.*') ? 'active' : '' }}"
                        href="{{ route('member.orders.index') }}"><i class="fas fa-history"></i> Riwayat Pesanan</a>
                </li>
                <li class="sidebar-heading">Lainnya</li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}"><i class="fas fa-home"></i> Kembali ke
                        Toko</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <nav class="topnav navbar navbar-expand navbar-dark">
                <div class="ms-auto"></div>
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=d4af37&color=1a1a1a&font-size=0.5"
                                alt="Avatar" class="user-avatar">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="page-content">
                @yield('content')
            </div>

            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Kestore.id {{ date('Y') }}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')
</body>

</html>
