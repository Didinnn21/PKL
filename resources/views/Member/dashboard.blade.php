@extends('layouts.member')

@section('title', 'Member Dashboard')

@section('styles')
    <style>
        /* Card Statistik */
        .stats-card-member {
            background-color: #2c2c2c;
            border: 1px solid #444;
            border-radius: 8px;
            color: #fff;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-card-member .icon {
            font-size: 2.2rem;
            color: #d4af37;
        }

        .stats-card-member .stat-title {
            font-size: 0.9rem;
            color: #ccc;
        }

        .stats-card-member .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
        }

        /* Carousel */
        .dashboard-carousel {
            margin-bottom: 2rem;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #333;
        }

        .dashboard-carousel .carousel-item img {
            height: 350px;
            object-fit: cover;
        }

        /* Card Riwayat Pesanan */
        .card-orders {
            background-color: #2c2c2c;
            border: 1px solid #444;
        }

        .table-dark-custom th {
            background-color: #333;
            border-color: #444 !important;
        }

        .table-dark-custom td,
        .table-dark-custom th {
            border-color: #444 !important;
        }

        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }

        /* Badge Status */
        .badge-status {
            font-size: 0.8rem;
            padding: 0.4em 0.7em;
            border-radius: 10px;
            color: #1a1a1a;
        }

        .badge-status-menunggu {
            background-color: #ffc107;
        }

        .badge-status-diproses {
            background-color: #d4af37;
        }

        .badge-status-dikirim {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-status-selesai {
            background-color: #28a745;
            color: #fff;
        }

        /* PERBAIKAN WARNA TEKS */
        .dashboard-header h1 {
            color: #f0f0f0;
            /* Teks "Selamat Datang" menjadi terang */
        }

        .card-orders .card-header {
            background-color: #333;
            /* Memberi latar belakang pada header kartu */
            color: #f0f0f0;
            /* Teks header kartu menjadi terang */
        }

        .table-dark-custom {
            color: #f0f0f0;
            /* Memastikan semua teks di dalam tabel berwarna terang */
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header Sambutan & Kartu Statistik -->
        <div class="row align-items-center mb-4">
            <div class="col-lg-5">
                <h1 class="h2">Selamat Datang, {{ Auth::user()->name }}!</h1>
            </div>
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-card-member">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">TOTAL PESANAN</div>
                                    <div class="stat-value">{{ $orders->total() }}</div>
                                </div>
                                <div class="icon"><i class="fas fa-box-archive"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card-member">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">PESANAN AKTIF</div>
                                    {{-- Menghitung pesanan yang belum selesai --}}
                                    <div class="stat-value">{{ $orders->whereNotIn('status', ['Selesai'])->count() }}</div>
                                </div>
                                <div class="icon"><i class="fas fa-truck-fast"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card-member">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">TOTAL BELANJA</div>
                                    <div class="stat-value">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="icon"><i class="fas fa-wallet"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel -->
        <div id="memberDashboardCarousel" class="carousel slide dashboard-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/Slide-1.jpg') }}" class="d-block w-100" alt="Promo">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Promo Spesial Untuk Anda</h5>
                        <p>Cek halaman produk untuk melihat penawaran terbaru kami.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Slide-2.png') }}" class="d-block w-100" alt="Produk Baru">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Desain Crewneck Terbaru</h5>
                        <p>Koleksi baru telah tiba, jangan sampai ketinggalan!</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#memberDashboardCarousel"
                data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#memberDashboardCarousel"
                data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="card card-orders">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i> Riwayat Pesanan Saya</h5>
                <a href="{{ route('landing') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-plus me-1"></i> Buat Pesanan Baru
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark-custom table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Produk</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Desain</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td><strong>#KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($order->product->image_url ?? 'https://placehold.co/50x50/252525/FFFFFF/png?text=N/A') }}"
                                                class="product-thumbnail">
                                            <span>{{ $order->product->name }} ({{ $order->quantity }}x)</span>
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = 'badge-status-menunggu';
                                            if ($order->status == 'Sedang Diproses')
                                                $statusClass = 'badge-status-diproses';
                                            if ($order->status == 'Telah Dikirim')
                                                $statusClass = 'badge-status-dikirim';
                                            if ($order->status == 'Selesai')
                                                $statusClass = 'badge-status-selesai';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $order->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($order->design_file)
                                            <a href="{{ asset('storage/' . $order->design_file) }}"
                                                class="btn btn-sm btn-outline-secondary" download>
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Anda belum memiliki riwayat pesanan.</h5>
                                        <p>Mari buat pesanan pertama Anda!</p>
                                        <a href="{{ route('landing') }}" class="btn btn-warning mt-2">Mulai Belanja</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
