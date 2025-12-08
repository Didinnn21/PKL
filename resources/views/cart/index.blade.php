@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@push('styles')
    <style>
        /* --- Cart Card --- */
        .cart-card {
            background-color: #141414;
            /* Abu Sangat Gelap */
            border: 1px solid #333;
            border-radius: 12px;
            overflow: hidden;
        }

        .cart-item-row {
            border-bottom: 1px solid #333;
            padding: 1.5rem;
            transition: background-color 0.2s;
        }

        .cart-item-row:last-child {
            border-bottom: none;
        }

        .cart-item-row:hover {
            background-color: #1a1a1a;
        }

        .product-image-cart {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #444;
        }

        /* --- Quantity Input --- */
        .quantity-input {
            width: 60px;
            background-color: #1f1f1f;
            color: #ffffff;
            border: 1px solid #444;
            text-align: center;
            border-radius: 6px;
        }

        .quantity-input:focus {
            background-color: #1f1f1f;
            border-color: #d4af37;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.2);
        }

        /* --- Summary Card --- */
        .summary-card {
            background-color: #0a0a0a;
            /* Hitam Pekat */
            border: 1px solid #333;
            border-radius: 12px;
            padding: 2rem;
            position: sticky;
            top: 100px;
            /* Sticky saat scroll */
        }

        /* --- Buttons --- */
        .btn-update {
            border: 1px solid #666;
            color: #ccc;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-update:hover {
            border-color: #d4af37;
            color: #d4af37;
            background: transparent;
        }

        .btn-remove {
            color: #ef4444;
            /* Merah */
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0.5rem;
        }

        .btn-remove:hover {
            color: #ff6b6b;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="text-white text-3xl font-bold fw-bold mb-0">Keranjang Belanja</h1>
            <span class="badge bg-dark border border-secondary text-light">
                {{ $cartItems->count() }} Item
            </span>
        </div>

        {{-- Alert Notification --}}
        @if (session('success'))
            <div class="alert alert-success bg-success bg-opacity-25 text-white border-0 mb-4 fade show">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger bg-danger bg-opacity-25 text-white border-0 mb-4 fade show">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="cart-card p-5 text-center">
                <div class="mb-3">
                    <i class="fas fa-shopping-cart fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-white">Keranjang Anda masih kosong</h4>
                <p class="text-muted mb-4">Yuk, cari produk favoritmu sekarang!</p>
                <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold px-4 py-2 text-dark">
                    <i class="fas fa-search me-2"></i> Mulai Belanja
                </a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-card shadow-sm">
                        @php $subtotal = 0; @endphp

                        @foreach ($cartItems as $item)
                            <div class="cart-item-row d-flex flex-column flex-md-row align-items-center">

                                <div class="me-md-4 mb-3 mb-md-0 flex-shrink-0">
                                    <img src="{{ asset('images/product/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}" class="product-image-cart"
                                        onerror="this.src='{{ asset('images/kestore-logo.png') }}';">
                                </div>

                                <div class="flex-grow-1 text-center text-md-start mb-3 mb-md-0">
                                    <h5 class="mb-1 text-white fw-bold">
                                        <a href="{{ route('product.detail', $item->product_id) }}"
                                            class="text-decoration-none text-white hover-gold">
                                            {{ $item->product->name }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-0">Harga Satuan: <span class="text-warning">Rp
                                            {{ number_format($item->product->price, 0, ',', '.') }}</span></p>
                                    <p class="text-muted small mb-0">Stok Tersedia: {{ $item->product->stock }}</p>
                                </div>

                                <div class="d-flex align-items-center mx-md-4 mb-3 mb-md-0">
                                    <form action="{{ route('member.cart.update', $item->id) }}" method="POST"
                                        class="d-flex align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->product->stock }}"
                                            class="form-control form-control-sm quantity-input me-2">
                                        <button type="submit" class="btn btn-update btn-sm" title="Perbarui Jumlah">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="text-end min-w-100 mb-3 mb-md-0">
                                    <strong class="text-white d-block">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</strong>
                                </div>

                                <div class="ms-md-3">
                                    <form action="{{ route('member.cart.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus item ini dari keranjang?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove" title="Hapus Item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @php $subtotal += $item->product->price * $item->quantity; @endphp
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('member.products.index') }}"
                            class="text-decoration-none text-muted hover-white small">
                            <i class="fas fa-arrow-left me-1"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card shadow-lg">
                        <h4 class="text-white mb-4 border-bottom border-secondary pb-3 fw-bold">
                            Ringkasan Belanja
                        </h4>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Item</span>
                            <strong class="text-white">{{ $cartItems->sum('quantity') }} pcs</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <strong class="text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>

                        <hr class="border-secondary my-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="text-white fw-bold mb-0">Total Harga</h5>
                            <h4 class="text-warning fw-bold mb-0">Rp {{ number_format($subtotal, 0, ',', '.') }}</h4>
                        </div>

                        <a href="{{ route('member.checkout.index') }}"
                            class="btn btn-warning w-100 py-3 fw-bold text-dark fs-6 shadow-sm hover-shadow">
                            Lanjutkan Pembayaran <i class="fas fa-arrow-right ms-2"></i>
                        </a>

                        <div class="mt-4 text-center">
                            <small class="text-muted d-block mb-1">Metode Pembayaran Aman</small>
                            <div class="text-muted opacity-50">
                                <i class="fas fa-lock me-1"></i> SSL Secured
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
