<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Kestore.id</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-top {
            background-color: #252525;
            border-bottom: 1px solid #333;
        }

        .navbar-brand, .nav-link, .navbar-text {
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
        }

        .sidebar .nav-link i.nav-icon {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #333;
            border-radius: 5px;
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
        }

        .sidebar .nav-dropdown .nav-link {
            padding-left: 2.5rem;
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

        /* --- STYLE BARU UNTUK NOTIFIKASI --- */
        .notification-dropdown .dropdown-toggle::after {
            display: none; /* Sembunyikan panah default */
        }

        .notification-icon {
            position: relative;
            font-size: 1.5rem;
            color: #ccc;
        }

        .notification-icon:hover {
            color: #fff;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            padding: 0.2em 0.4em;
            font-size: 0.7rem;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            background-color: #dc3545;
            border-radius: 50%;
        }

        .notification-dropdown .dropdown-menu {
            width: 350px;
            background-color: #333;
            border-color: #444;
            color: #f0f0f0;
        }

        .notification-dropdown .dropdown-header {
            background-color: #252525;
            color: #d4af37;
            font-weight: 600;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #444;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item a {
            text-decoration: none;
            color: #f0f0f0;
        }

        .notification-item:hover {
            background-color: #444;
        }

        .notification-item .icon {
            font-size: 1.2rem;
            color: #d4af37;
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .notification-item .message {
            font-size: 0.9rem;
        }

        .notification-item .time {
            font-size: 0.75rem;
            color: #aaa;
        }
        /* --- AKHIR STYLE NOTIFIKASI --- */

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items:center" href="{{ url('/') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo" style="height: 30px; margin-right: 10px;">
                    KESTORE.ID
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">

                        <!-- PERUBAHAN: Menambahkan Dropdown Notifikasi -->
                        <li class="nav-item dropdown notification-dropdown me-3">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="notification-icon">
                                    <i class="fas fa-bell"></i>
                                    <span class="notification-badge">3</span> <!-- Angka ini bisa dinamis -->
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <div class="dropdown-header">
                                    Notifikasi (3 Pesanan Baru)
                                </div>
                                <div class="notification-item">
                                    <a href="#" class="d-flex">
                                        <div class="icon"><i class="fas fa-receipt"></i></div>
                                        <div>
                                            <div class="message">Pesanan baru <strong>#KESTORE-001</strong> dari Andi.</div>
                                            <div class="time">5 menit yang lalu</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="notification-item">
                                    <a href="#" class="d-flex">
                                        <div class="icon"><i class="fas fa-receipt"></i></div>
                                        <div>
                                            <div class="message">Pesanan baru <strong>#KESTORE-002</strong> dari Citra.</div>
                                            <div class="time">15 menit yang lalu</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="notification-item">
                                    <a href="#" class="d-flex">
                                        <div class="icon"><i class="fas fa-receipt"></i></div>
                                        <div>
                                            <div class="message">Pesanan baru <strong>#KESTORE-003</strong> dari Doni.</div>
                                            <div class="time">1 jam yang lalu</div>
                                        </div>
                                    </a>
                                </div>
                                 <a class="dropdown-item text-center small text-muted" href="#">Lihat semua notifikasi</a>
                            </div>
                        </li>

                        @auth
                            <li class="nav-item">
                                <span class="navbar-text">Halo, {{ Auth::user()->name }}</span>
                            </li>
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
                <!-- Sidebar -->
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-home nav-icon"></i> Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-box-open nav-icon"></i> Product
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle" href="#orders-submenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="orders-submenu">
                                    <i class="fas fa-shopping-cart nav-icon"></i> Pesanan
                                </a>
                                <div class="collapse nav-dropdown" id="orders-submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pesanan Satuan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pesanan Lusinan</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-address-book nav-icon"></i> Contact
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>

