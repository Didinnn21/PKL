@extends('layouts.member')

@section('title', 'Katalog Produk')

@push('styles')
    <style>
        .product-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .product-image-container {
            height: 250px;
            overflow: hidden;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card .card-body {
            padding: 1.25rem;
        }

        .product-card .card-title {
            color: var(--text-light);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card .card-price {
            color: var(--primary-gold);
            font-size: 1.25rem;
            font-weight: 700;
        }

        .btn-detail {
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
            color: var(--dark-bg);
            font-weight: 600;
            width: 100%;
        }

        .btn-detail:hover {
            background-color: #b39330;
            border-color: #b39330;
        }

        /* Filter Section */
        .filter-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .form-control,
        .form-select {
            background-color: var(--dark-surface);
            border-color: var(--dark-border);
            color: var(--text-light);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--dark-surface);
            border-color: var(--primary-gold);
            color: var(--text-light);
            box-shadow: none;
        }

        .pagination .page-link {
            background-color: var(--dark-surface-2);
            border-color: var(--dark-border);
            color: var(--text-muted);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
            color: var(--dark-bg);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-1 pb-2 mb-4" style="color:var(--text-light); border-bottom: 1px solid var(--dark-border);">
            Katalog Produk
        </h1>

        {{-- Filter dan Sorting --}}
        <div class="filter-card mb-4">
            <form action="{{ route('member.products.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    {{-- Urutkan --}}
                    <div class="col-md-3">
                        <label for="sort" class="form-label">Urutkan</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="terbaru" @if(request('sort') == 'terbaru') selected @endif>Terbaru</option>
                            <option value="harga_terendah" @if(request('sort') == 'harga_terendah') selected @endif>Harga
                                Terendah</option>
                            <option value="harga_tertinggi" @if(request('sort') == 'harga_tertinggi') selected @endif>Harga
                                Tertinggi</option>
                        </select>
                    </div>
                    {{-- Filter Harga --}}
                    <div class="col-md-3">
                        <label for="min_price" class="form-label">Harga Minimum</label>
                        <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Rp 0"
                            value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="max_price" class="form-label">Harga Maksimum</label>
                        <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Rp 1.000.000"
                            value="{{ request('max_price') }}">
                    </div>
                    {{-- Tombol Terapkan --}}
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-detail w-100">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Daftar Produk --}}
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-md-4">
                    <div class="card product-card">
                        <div class="product-image-container">
                            <img src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-detail mt-2">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Produk tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
