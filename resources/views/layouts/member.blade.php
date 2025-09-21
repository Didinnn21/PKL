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
        /* =================================== */
        /* == PERBAIKAN DESAIN & SCROLL == */
        /* =================================== */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
            font-family: 'Poppins', sans-serif;
        }

        #app {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .main-wrapper {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .sidebar {
            background-color: #252525;
            flex-shrink: 0;
            width: 280px;
            height: 100%;
            overflow-y: auto;
            border-right: 1px solid #333;
        }

        main {
            overflow-y: auto;
            flex-grow: 1;
            padding: 2rem;
        }

        .navbar-top {
            background-color: #252525;
            border-bottom: 1px solid #333;
            flex-shrink: 0;
        }

        .navbar-brand,
        .nav-link,
        .navbar-text {
            color: #d4af37 !important;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #ccc;
            padding: 0.85rem 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            border-left: 3px solid transparent;
            transition: all 0.2s ease-in-out;
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

        .logout-form .btn-logout {
            background: none;
            border: none;
            color: #d4af37 !important;
            font-weight: 600;
            padding: 0.5rem 1rem;
            text-align: left;
        }

        .carousel-caption {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0));
            padding: 1.5rem;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 0 0 8px 8px;
        }

        .dashboard-carousel .carousel-item img {
            border-radius: 8px;
        }

        .carousel-caption h5,
        .carousel-caption p {
            color: #fff !important;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
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
        <div class="main-wrapper">
            <nav id="sidebarMenu" class="d-md-block sidebar collapse">
                <div class="pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                                href="{{ route('member.dashboard') }}">
                                <i class="fas fa-home nav-icon"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('landing') }}#koleksi">
                                <i class="fas fa-box-open nav-icon"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.orders.*') ? 'active' : '' }}"
                                href="{{ route('member.orders.index') }}">
                                <i class="fas fa-shopping-cart nav-icon"></i> Pesanan Saya
                            </a>
                        </li>
                        <li class="nav-item mt-3 border-top pt-3 border-secondary">
                            <a class="nav-link" href="#">
                                <i class="fas fa-info-circle nav-icon"></i> Tentang Kestore.id
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-address-book nav-icon"></i> Kontak
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main>
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
