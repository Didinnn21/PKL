<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kestore.id</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- ===== GAYA CUSTOM KESTORE.ID ===== -->
    <style>
        html,
        body {
            background-color: #1a1a1a !important;
            color: #f0f0f0;
            font-family: 'Poppins', sans-serif;
        }

        #app {
            background-color: #1a1a1a;
        }

        .navbar {
            background-color: #252525 !important;
            border-bottom: 1px solid #333;
        }

        .navbar-brand,
        .nav-link {
            color: #d4af37 !important;
            font-weight: 600;
        }

        .navbar-brand .logo {
            height: 30px;
            margin-right: 10px;
        }

        .card {
            background-color: #252525;
            border: 1px solid #444;
        }

        .card-header {
            font-size: 1.25rem;
            font-weight: 600;
            color: #f0f0f0;
            background-color: #333;
            border-bottom: 1px solid #444;
        }

        .form-label,
        .form-check-label {
            color: #ccc;
        }

        .form-control {
            background-color: #333;
            border: 1px solid #555;
            color: #fff;
        }

        .form-control:focus {
            background-color: #333;
            border-color: #d4af37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
            color: #fff;
        }

        .btn-primary {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #1a1a1a;
            font-weight: 600;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #b39330;
            border-color: #b39330;
            color: #1a1a1a;
        }

        .btn-link {
            color: #d4af37;
            text-decoration: none;
        }

        .btn-link:hover {
            color: #fff;
        }

        .form-control::placeholder {
            color: #888;
            opacity: 1;
        }

        .form-control:-ms-input-placeholder {
            color: #888;
        }

        .form-control::-ms-input-placeholder {
            color: #888;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo" class="logo">
                    KESTORE.ID
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
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
                            <li class="nav-item">
                                <span class="nav-link">Halo, {{ Auth::user()->name }}</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>

</html>
