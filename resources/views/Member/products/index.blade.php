@extends('layouts.member')

@section('title', 'Katalog Produk')

@push('styles')
    <style>
        /* --- Filter Card --- */
        .filter-card {
            background-color: #141414;
            border: 1px solid #333;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        /* --- Product Card --- */
        .product-card {
            background-color: #141414;
            border: 1px solid #333;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: #D4AF37;
            /* Border Emas saat Hover */
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.15);
        }

        .product-image-container {
            height: 220px;
            width: 100%;
            overflow: hidden;
            position: relative;
            background-color: #000;
            border-bottom: 1px solid #333;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.1);
            /* Efek Zoom saat Hover */
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-title {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .card-price {
            color: #D4AF37;
            /* Teks Emas */
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .card-desc {
            color: #a3a3a3;
            /* Abu Terang */
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            /* Agar tombol selalu di bawah */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* --- Buttons --- */
        .btn-detail {
            background-color: transparent;
            border: 1px solid #D4AF37;
            color: #D4AF37;
            font-weight: 600;
            width: 100%;
            padding: 0.5rem;
            transition: all 0.3s;
            border-radius: 8px;
        }

        .btn-detail:hover {
            background-color: #D4AF37;
            color: #000;
            /* Teks hitam saat hover */
        }

        .btn-gold-solid {
            background-color: #D4AF37;
            color: #000;
            border: none;
            font-weight: 700;
            border-radius: 8px;
        }

        .btn-gold-solid:hover {
            background-color: #f1c40f;
            color: #000;
        }

        /* --- Form Elements (Dark Theme Fix) --- */
        .form-label {
            color: #fff;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            background-color: #1f1f1f;
            border: 1px solid #444;
            color: #fff;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #1f1f1f;
            border-color: #D4AF37;
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.2);
        }

        .input-group-text {
            background-color: #2c2c2c;
            border-color: #444;
            color: #D4AF37;
        }

        /* --- Pagination --- */
        .pagination {
            margin-top: 2rem;
        }

        .pagination .page-item .page-link {
            background-color: #141414;
            border-color: #333;
            color: #fff;
        }

        .pagination .page-item.active .page-link {
            background-color: #D4AF37;
            border-color: #D4AF37;
            color: #000;
            font-weight: bold;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #0a0a0a;
            border-color: #333;
            color: #555;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold text-white mb-0">Katalog Produk</h2>
        </div>

        <div class="filter-card">
            <form action="{{ route('member.products.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="terbaru" @if(request('sort') == 'terbaru') selected @endif>Produk Terbaru</option>
                            <option value="harga_terendah" @if(request('sort') == 'harga_terendah') selected @endif>Harga
                                Terendah</option>
                            <option value="harga_tertinggi" @if(request('sort') == 'harga_tertinggi') selected @endif>Harga
                                Tertinggi</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="min_price" class="form-label">Harga Minimum</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0"
                                value="{{ request('min_price') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="max_price" class="form-label">Harga Maksimum</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Max"
                                value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-gold-solid w-100">
                            <i class="fas fa-filter me-2"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card product-card">
                        <div class="product-image-container">
                            {{-- Cek 1: Jika gambar disimpan di public/images/product/ (Manual/Seeder) --}}
                            {{-- @if(file_exists(public_path('images/product/' . $product->image_url)))
                                <img src="{{ asset('storage/products/' . $product->image_url) }}" alt="{{ $product->name }}"> --}}

                                {{-- Cek 2: Jika gambar disimpan di storage (Upload Admin) --}}
                            {{-- @elseif($product->image && file_exists(storage_path('app/public/products' . $product->image)))
                                <img src="{{ asset('store' . $product->image_url) }}" alt="{{ $product->name }}"> --}}

                                {{-- Fallback: Jika tidak ada gambar, tampilkan placeholder/logo --}}
                            {{-- @else
                                <img src="{{ asset('images/kestore-logo.png') }}" alt="{{ $product->name }}"
                                    style="object-fit: contain; padding: 20px; opacity: 0.5;">
                            @endif --}}
                            @if (file_exists(public_path($product->image_url)))
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/kestore-logo.png') }}" alt="{{ $product->name }}">
                            @endif
                            {{-- Badge Harga Overlay (Opsional) --}}
                            <div class="position-absolute top-0 end-0 m-3 px-3 py-1 bg-warning text-dark fw-bold rounded-pill shadow small">
                                Stok: {{ $product->stock }}
                            </div>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                            <p class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="card-desc">{{ $product->description }}</p>

                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-detail mt-auto">
                                <i class="fas fa-eye me-2"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 rounded border border-secondary" style="background-color: #141414;">
                        <i class="fas fa-box-open fa-3x text-secondary mb-3"></i>
                        <h4 class="text-white">Produk Tidak Ditemukan</h4>
                        <p class="text-muted">Coba ubah filter harga atau kembali lagi nanti.</p>
                        <a href="{{ route('member.products.index') }}" class="btn btn-outline-light mt-2">
                            <i class="fas fa-sync-alt me-2"></i> Reset Filter
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
