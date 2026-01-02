<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Member') - Kestore.id</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            /* Tema Gold & Black */
            --bg-body: #0a0a0a;
            /* Hitam Pekat */
            --bg-sidebar: #000000;
            /* Hitam Murni */
            --bg-card: #141414;
            /* Abu Sangat Gelap */
            --bg-input: #1f1f1f;
            /* Background Input */
            --border-color: #333333;
            --gold-primary: #D4AF37;
            --gold-hover: #F1C40F;
            --gold-dim: rgba(212, 175, 55, 0.1);
            --text-white: #ffffff;
            --text-muted: #e0e0e0;
            /* UBAH: Abu menjadi Putih Terang */
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-white);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            overflow-x: hidden;
        }

        /* --- GLOBAL STYLES AGAR TEKS PUTIH KELIHATAN --- */

        /* 1. Paksa text-muted (abu bawaan bootstrap) jadi putih terang */
        .text-muted {
            color: var(--text-muted) !important;
        }

        /* 2. Card (Kotak Konten) */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-white);
            /* Paksa teks putih */
        }

        .card-header,
        .card-footer {
            background-color: rgba(255, 255, 255, 0.02);
            border-color: var(--border-color);
            color: var(--text-white);
        }

        /* 3. Input Form (PENTING: Agar teks putih terlihat, background harus gelap) */
        .form-control,
        .form-select {
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            color: #ffffff !important;
            /* Paksa teks putih */
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--bg-input);
            border-color: var(--gold-primary);
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem var(--gold-dim);
        }

        .form-control::placeholder {
            color: #cccccc !important;
            /* Placeholder Putih Terang */
            opacity: 1;
        }

        /* Fix untuk autofill browser */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px var(--bg-input) inset !important;
            -webkit-text-fill-color: white !important;
        }

        /* 4. Tabel */
        .table {
            color: var(--text-white);
            border-color: var(--border-color);
        }

        .table thead th {
            color: var(--gold-primary);
            border-bottom: 2px solid var(--border-color);
        }

        .table td,
        .table th {
            border-top: 1px solid var(--border-color);
            color: var(--text-white);
            /* Pastikan isi tabel putih */
        }

        .table-hover tbody tr:hover {
            color: var(--text-white);
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            /* min-height: 100vh; */
            position: sticky;
            top: 0;
            height: 100vh;
            padding-top: 1rem;
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

        .nav-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-white);
            padding: 1rem 1.5rem 0.5rem;
            font-weight: 700;
            opacity: 0.9;
        }

        .nav-link {
            color: var(--text-white);
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
            color: var(--text-white);
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

        .navbar-top {
            background-color: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }

        /* Button Logout */
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

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-sidebar);
        }

        ::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <div
                        class="px-4 py-4 mb-3 d-flex align-items-center justify-content-center border-bottom border-secondary">
                        <a class="navbar-brand d-flex align-items-center" href="{{ route('member.dashboard') }}">
                            <img src="{{ asset('images/kestore-logo.png') }}" alt="Logo"
                                style="height: 32px; margin-right: 10px;">
                            KESTORE<span>.ID</span>
                        </a>
                    </div>

                    <ul class="nav flex-column mt-2">
                        <div class="nav-category">Menu Member</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                                href="{{ route('member.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.products.index') ? 'active' : '' }}"
                                href="{{ route('member.products.index') }}">
                                <i class="fas fa-store"></i> Belanja Produk
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.custom.create') ? 'active' : '' }}"
                                href="{{ route('member.custom.create') }}">
                                <i class="fas fa-drafting-compass"></i> Pesan Custom
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.cart.index') ? 'active' : '' }}"
                                href="{{ route('member.cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> Keranjang Saya
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.orders.index') ? 'active' : '' }}"
                                href="{{ route('member.orders.index') }}">
                                <i class="fas fa-clipboard-list"></i> Riwayat Pesanan
                            </a>
                        </li>

                        <div class="nav-category mt-3">Akun</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                href="{{ route('profile.index') }}">
                                <i class="fas fa-user-circle"></i> Profil Saya
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <nav class="navbar navbar-expand-md navbar-top sticky-top">
                    <div class="container-fluid">
                        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse"
                            data-bs-target="#sidebar">
                            <i class="fas fa-bars"></i>
                        </button>

                        <div class="d-flex align-items-center ms-auto">
                            <div class="me-4 text-white d-none d-md-block text-end">
                                <small class="text-white opacity-75">Halo, Member</small>
                                <span class="text-white fw-bold d-block">{{ Auth::user()->name }}</span>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-logout">
                                    <i class="fas fa-power-off me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @yield('content')
                </div>

                <footer class="mt-auto py-4 border-top"
                    style="border-color: var(--border-color) !important; background-color: var(--bg-body);">
                    <div class="container-fluid text-center">
                        <span class="small" style="color: #ffffff; letter-spacing: 0.5px;">
                            &copy; {{ date('Y') }}
                            <span class="fw-bold text-white">Kestore</span><span
                                style="color: var(--gold-primary)">.id</span>
                        </span>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
