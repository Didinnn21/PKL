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

        #layoutSidenav {
            display: flex;
        }

        #layoutSidenav_nav {
            flex-basis: 225px;
            flex-shrink: 0;
        }

        #layoutSidenav_content {
            flex-grow: 1;
            min-width: 0;
            padding: 2rem;
        }

        .sb-topnav {
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
        }

        .sb-sidenav {
            background-color: var(--dark-surface);
        }

        .sb-sidenav .sb-sidenav-menu .nav .nav-link {
            color: var(--text-muted);
        }

        .sb-sidenav .sb-sidenav-menu .nav .nav-link .sb-nav-link-icon {
            color: var(--text-muted);
        }

        .sb-sidenav .sb-sidenav-menu .nav .nav-link:hover {
            color: #fff;
        }

        .sb-sidenav .sb-sidenav-menu .nav .nav-link.active {
            color: var(--primary-gold);
        }

        .sb-sidenav .sb-sidenav-menu .nav .nav-link.active .sb-nav-link-icon {
            color: var(--primary-gold);
        }

        .sb-sidenav-dark .sb-sidenav-footer {
            background-color: var(--dark-surface-2);
        }

        .navbar-brand,
        .dropdown-item {
            color: var(--primary-gold);
        }

        .dropdown-menu {
            background-color: var(--dark-surface-2);
            border-color: var(--dark-border);
        }

        .dropdown-item:hover {
            background-color: var(--dark-bg);
        }
    </style>
    @stack('styles')
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <a class="navbar-brand ps-3" href="{{ route('member.dashboard') }}">Kestore.id Member</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <div class="ms-auto"></div>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Utama</div>
                        <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                            href="{{ route('member.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Toko</div>
                        <a class="nav-link {{ request()->routeIs('member.products.index') ? 'active' : '' }}"
                            href="{{ route('member.products.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tshirt"></i></div>
                            Katalog Produk
                        </a>
                        <a class="nav-link {{ request()->routeIs('member.orders.*') ? 'active' : '' }}"
                            href="{{ route('member.orders.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Riwayat Pesanan
                        </a>

                        <div class="sb-sidenav-menu-heading">Lainnya</div>
                        <a class="nav-link" href="{{ route('landing') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Kembali ke Toko
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->name }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Kestore.id {{ date('Y') }}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
