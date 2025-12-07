@extends('layouts.member')

@section('title', 'Dashboard Member')

@push('styles')
    <style>
        /* Card Statistik */
        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            color: #fff;
            /* Pastikan teks putih */
        }

        .stat-card:hover {
            border-color: var(--gold-primary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.1);
        }

        .stat-icon {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 2.5rem;
            color: var(--gold-primary);
            opacity: 0.1;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            margin-top: 5px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Product Card Mini */
        .product-card-mini {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            transition: 0.3s;
        }

        .product-card-mini:hover {
            border-color: var(--gold-primary);
        }

        .product-img {
            height: 150px;
            object-fit: cover;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold text-white mb-0">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-white mb-0 small opacity-75">Senang melihatmu kembali. Mau pesan apa hari ini?</p>
            </div>
            <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold text-dark">
                <i class="fas fa-shopping-bag me-2"></i> Belanja Sekarang
            </a>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Total Pesanan Saya</div>
                    <div class="stat-value">{{ $total_orders ?? 0 }}</div>
                    <i class="fas fa-clipboard-list stat-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Sedang Diproses</div>
                    <div class="stat-value">{{ $pending_orders ?? 0 }}</div>
                    <i class="fas fa-clock stat-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Total Pengeluaran</div>
                    <div class="stat-value">Rp {{ number_format($total_spent ?? 0, 0, ',', '.') }}</div>
                    <i class="fas fa-wallet stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h5 class="text-white fw-bold mb-0">Produk Terbaru</h5>
            <a href="{{ route('member.products.index') }}" class="text-warning text-decoration-none small fw-bold">Lihat
                Semua &rarr;</a>
        </div>

        <div class="row g-4">
            @forelse($recent_products ?? [] as $product)
                <div class="col-6 col-md-3">
                    <div class="product-card-mini h-100">
                        <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                        <div class="p-3">
                            <h6 class="text-white mb-1 text-truncate">{{ $product->name }}</h6>
                            <p class="text-warning fw-bold mb-2 small">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('product.detail', $product->id) }}"
                                class="btn btn-outline-light btn-sm w-100">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-white opacity-50 py-5">
                    Belum ada produk terbaru.
                </div>
            @endforelse
        </div>
    </div>
@endsection