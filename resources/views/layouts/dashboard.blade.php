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
        /* == PERBAIKAN DESAIN & FONT COLOR == */
        /* =================================== */
        body { background-color: #1a1a1a; color: #f0f0f0; font-family: 'Poppins', sans-serif; }
        .form-label { color: #ccc; font-weight: 500; }
        .form-control, .form-select { background-color: #333; border: 1px solid #555; color: #fff; }
        .form-control:focus, .form-select:focus { background-color: #333; border-color: #d4af37; box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25); color: #fff; }
        .form-control::placeholder { color: #888; opacity: 1; }
        .btn-warning { background-color: #d4af37; border-color: #d4af37; color: #1a1a1a; font-weight: 600; }
        .btn-warning:hover { background-color: #b39330; border-color: #b39330; color: #1a1a1a; }
        .navbar-top { background-color: #252525; border-bottom: 1px solid #333; }
        .navbar-brand, .nav-link, .navbar-text { color: #d4af37 !important; font-weight: 600; }
        .sidebar { background-color: #252525; min-height: 100vh; border-right: 1px solid #333; }
        .sidebar .nav-link { color: #ccc; padding: 0.75rem 1.5rem; font-size: 0.9rem; display: flex; align-items: center; border-left: 3px solid transparent; }
        .sidebar .nav-link i.nav-icon { width: 20px; margin-right: 12px; text-align: center; }
        .sidebar .nav-link:hover { color: #fff; background-color: #333; }
        .sidebar .nav-link.active { color: #fff; background-color: #1a1a1a; border-left-color: #d4af37; }
        .sidebar .dropdown-toggle::after { margin-left: auto; transition: transform 0.3s ease; }
        .sidebar .dropdown-toggle[aria-expanded="true"]::after { transform: rotate(90deg); }
        .sidebar .nav-dropdown { padding-left: 20px; background-color: rgba(0,0,0,0.2); }
        .sidebar .nav-dropdown .nav-link { padding-left: 1.5rem; border-left: none; }
        .sidebar .nav-dropdown .nav-link.active { background-color: #333; border-radius: 5px; }
        main { padding: 2rem; }
        .logout-form .btn-logout { background: none; border: none; color: #d4af37 !important; font-weight: 600; padding: 0.5rem 1rem; text-align: left; }
        .card { background-color: #2c2c2c; border: 1px solid #444; }
        .card-header { background-color: #333; border-bottom: 1px solid #444; }
        .nav-tabs .nav-link { color: #ccc; background: none; border-color: #333 #333 #444; }
        .nav-tabs .nav-link.active { color: #fff; background-color: #2c2c2c; border-color: #444 #444 #2c2c2c; }
        .table-dark-custom { background-color: #2c2c2c; color: #f0f0f0; }
        .table-dark-custom th { background-color: #333; border-color: #444 !important; color: #ccc; }
        .table-dark-custom td, .table-dark-custom th { border-color: #444 !important; }
        .badge { font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin/dashboard') }}">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo" style="height: 30px; margin-right: 10px;">
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
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt nav-icon"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="#products-submenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}">
                                    <i class="fas fa-box-open nav-icon"></i> Produk
                                </a>
                                <div class="collapse nav-dropdown {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="products-submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fas fa-list nav-icon"></i> Semua Produk</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}"><i class="fas fa-plus nav-icon"></i> Tambah Produk</a>
                                        </li>
                                    </ul>
                                </div>
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
                                <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="{{ route('admin.laporan.penjualan') }}">
                                    <i class="fas fa-chart-pie nav-icon"></i> Laporan
                                </a>
                            </li>
                            <li class="nav-item mt-3 border-top pt-3 border-secondary">
                                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
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
    @stack('scripts')
</body>
</html>
```

***

### 3. File Tampilan (Views)

Ganti semua file *view* admin Anda dengan versi di bawah ini. Saya telah menyesuaikannya agar cocok dengan desain baru dan menampilkan data dinamis dari *controller*.

#### `resources/views/Admin/laporan/penjualan.blade.php`
```php
@extends('layouts.dashboard')
@section('title', 'Laporan Penjualan')
@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Laporan Penjualan</h1>
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Grafik Pendapatan (6 Bulan Terakhir)</div>
                    <div class="card-body"><canvas id="salesReportChart"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Produk Terlaris</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($top_products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center" style="background:none; color: #fff; border-color: #444;">
                                    {{ $product->name }} <span class="badge bg-warning text-dark rounded-pill">{{ $product->sold }} Terjual</span>
                                </li>
                            @empty
                                <li class="list-group-item" style="background:none; color: #fff;">Belum ada data penjualan.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const salesCtx = document.getElementById('salesReportChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: @json($salesChartData['labels']),
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: @json($salesChartData['data']),
                        backgroundColor: '#d4af37',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { labels: { color: '#fff' } } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#ccc' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                        x: { ticks: { color: '#ccc' }, grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endpush
```

#### `resources/views/Admin/pengaturan/index.blade.php`
```php
@extends('layouts.dashboard')
@section('title', 'Pengaturan')
@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Pengaturan</h1>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                 <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profil Admin</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#store" type="button" role="tab">Pengaturan Toko</button></li>
                 </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="settingsTabsContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <h5>Profil Admin</h5>
                        <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')
                            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required></div><hr class="border-secondary my-4">
                            <p class="text-muted">Isi hanya jika Anda ingin mengubah password.</p>
                            <div class="mb-3"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="form-control"></div>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="store" role="tabpanel" >
                         <h5>Pengaturan Toko</h5>
                         <form class="mt-3">
                            <div class="mb-3"><label class="form-label">Nama Toko</label><input type="text" class="form-control" value="Kestore.id" disabled></div>
                            <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" rows="3" disabled>Jl. Kenangan No. 123, Kota Bandung, Jawa Barat</textarea></div>
                            <button type="submit" class="btn btn-warning" disabled>Simpan Pengaturan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

