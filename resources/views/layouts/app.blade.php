<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kestore.id') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --bg-body: #000000;
            --bg-nav: #0a0a0a;
            --border-color: #333333;
            --gold-primary: #d4af37;
            --gold-hover: #f1c40f;
            --text-white: #ffffff;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-white);
            font-family: 'Nunito', sans-serif;
        }

        /* --- NAVBAR STYLING --- */
        .navbar {
            background-color: var(--bg-nav) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .navbar-brand img {
            height: 45px;
            /* Logo sedikit lebih besar */
            transition: transform 0.3s;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* Nav Links */
        .navbar-dark .navbar-nav .nav-link {
            color: #ffffff !important;
            /* Text Putih */
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .navbar-dark .navbar-nav .nav-link:hover,
        .navbar-dark .navbar-nav .nav-link:focus {
            color: var(--gold-primary) !important;
            /* Hover Emas */
        }

        /* Toggler (Mobile Menu Icon) */
        .navbar-toggler {
            border-color: #444;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

        /* Dropdown Menu (User Profile) */
        .dropdown-menu {
            background-color: #141414;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .dropdown-item {
            color: #ffffff;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #1f1f1f;
            color: var(--gold-primary);
        }

        /* --- GLOBAL COMPONENTS --- */

        /* Card Styles (untuk halaman lain yang extend app ini) */
        .card {
            background-color: #0a0a0a;
            border: 1px solid var(--border-color);
        }

        .card-header {
            background-color: #141414;
            border-bottom: 1px solid var(--border-color);
            color: #fff;
            font-weight: 700;
        }

        /* Alerts */
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    <div class="bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 32px; height: 32px; border: 1px solid #444;">
                                        <i class="fas fa-user text-white small"></i>
                                    </div>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('member.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-secondary"></i> Dashboard
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <i class="fas fa-user-circle me-2 text-secondary"></i> Profil Saya
                                    </a>
                                    <div class="dropdown-divider" style="border-color: #333;"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            {{-- NOTIFIKASI --}}
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>

</html>
