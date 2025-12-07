<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Kestore.id</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            /* Palette Warna Mewah */
            --bg-body: #0a0a0a;          /* Hitam Pekat */
            --bg-sidebar: #000000;       /* Hitam Murni */
            --bg-card: #141414;          /* Abu Sangat Gelap */
            --bg-input: #1f1f1f;

            --border-color: #333333;     /* Garis Sedikit Lebih Terang */

            --gold-primary: #D4AF37;     /* Emas Murni */
            --gold-hover: #F1C40F;       /* Emas Terang */
            --gold-dim: rgba(212, 175, 55, 0.1);

            --text-primary: #ffffff;
            --text-secondary: #ffffff;   /* UBAH JADI PUTIH (Sebelumnya Abu) */
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            overflow-x: hidden;
        }

        /* --- NAVBAR --- */
        .navbar-top {
            background-color: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
        }

        .navbar-brand span {
            color: var(--gold-primary);
        }

        /* --- SIDEBAR --- */
        .sidebar {
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            min-height: 100vh;
            padding-top: 1rem;
        }

        .nav-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #ffffff; /* UBAH JADI PUTIH */
            padding: 1rem 1.5rem 0.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .nav-link {
            color: #ffffff; /* UBAH JADI PUTIH */
            padding: 0.75rem 1.5rem;
            font-weight: 400;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            opacity: 0.8;
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
            color: #ffffff; /* Icon Putih */
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            opacity: 1;
        }

        .nav-link:hover i {
            color: var(--gold-primary);
        }

        .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, var(--gold-dim) 0%, transparent 100%);
            border-left-color: var(--gold-primary);
            font-weight: 600;
            opacity: 1;
        }

        .nav-link.active i {
            color: var(--gold-primary);
        }

        /* --- CONTENT AREA --- */
        main {
            padding: 2rem;
        }

        /* --- CARD STYLING --- */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* --- FORM ELEMENTS --- */
        .form-control, .form-select {
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 0.6rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--bg-input);
            border-color: var(--gold-primary);
            color: #fff;
            box-shadow: 0 0 0 0.25rem var(--gold-dim);
        }

        .form-control::placeholder {
            color: #bbbbbb; /* Placeholder lebih terang */
        }

        /* --- TABLES --- */
        .table {
            color: #ffffff; /* Teks tabel putih */
            vertical-align: middle;
            margin-bottom: 0;
        }

        .table th {
            color: var(--gold-primary); /* Header tabel emas */
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            background-color: transparent;
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .table td {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            background-color: transparent;
            color: #fff;
        }

        .table-hover tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        /* --- BUTTONS --- */
        .btn-gold {
            background-color: var(--gold-primary);
            color: #000;
            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
            color: #000;
        }

        .btn-logout {
            color: #ff6b6b;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #fff;
        }

        /* --- SCROLLBAR --- */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-sidebar); }
        ::-webkit-scrollbar-thumb { background: #444; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-primary); }

        /* Bootstrap Overrides */
        .text-muted { color: #d1d1d1 !important; }
        .text-secondary { color: #e0e0e0 !important; }
    </style>

    @stack('styles')
</head>

<body>
    <div id="app" class="container-fluid p-0">
        <div class="row g-0">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <div class="px-4 py-4 mb-3 d-flex align-items-center justify-content-center border-bottom border-secondary">
                        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                            <img src="{{ asset('images/kestore-logo.png') }}" alt="Logo" style="height: 32px; margin-right: 10px;">
                            KESTORE<span>.ID</span>
                        </a>
                    </div>

                    <ul class="nav flex-column mt-2">
                        <div class="nav-category">Utama</div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                <i class="fas fa-tshirt"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-bag"></i> Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                                <i class="fas fa-users"></i> Pelanggan
                            </a>
                        </li>

                        <div class="nav-category mt-3">Lainnya</div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="{{ route('admin.laporan.penjualan') }}">
                                <i class="fas fa-chart-line"></i> Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                <i class="fas fa-cog"></i> Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <nav class="navbar navbar-expand-md navbar-top sticky-top">
                    <div class="container-fluid">
                        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>

                        <div class="d-flex align-items-center ms-auto">
                            @auth
                                <div class="me-4 text-white d-none d-md-block">
                                    <small class="text-white opacity-75">Selamat datang,</small>
                                    <span class="text-white fw-bold d-block">{{ Auth::user()->name }}</span>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-logout">
                                        <i class="fas fa-power-off me-1"></i> Logout
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @yield('content')
                </div>

                <footer class="mt-auto py-3 px-4 border-top"
                    style="border-color: var(--border-color) !important; background-color: var(--bg-body);">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between small">

                        <div class="text-secondary mb-2 mb-md-0">
                            Copyright &copy; {{ date('Y') }}
                            <span class="fw-bold text-white">KESTORE</span><span style="color: var(--gold-primary)">.ID</span>.
                            <span class="d-none d-sm-inline">All rights reserved.</span>
                        </div>

                        <div class="text-secondary opacity-75">
                            Admin Dashboard <span class="mx-1">&middot;</span> v1.0.0
                        </div>

                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')
</body>
</html>
