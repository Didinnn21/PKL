@extends('layouts.app')

@section('title', $product->name)

@push('styles')
    <style>
        .product-detail-card {
            background-color: #252525;
            border: 1px solid #444;
            border-radius: 15px;
            overflow: hidden;
        }

        .product-image-main {
            border-radius: 15px;
            width: 100%;
            height: 550px;
            object-fit: cover;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 600;
            color: #d4af37;
        }

        .product-stock {
            font-weight: 500;
            color: #f0f0f0;
        }

        .product-description {
            line-height: 1.8;
        }

        /* Quantity Selector Interaktif */
        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid #444;
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-selector button {
            background-color: #2c2c2c;
            color: #f0f0f0;
            border: none;
            font-size: 1.2rem;
            width: 45px;
            height: 45px;
            cursor: pointer;
        }

        .quantity-selector input {
            width: 60px;
            height: 45px;
            text-align: center;
            border: none;
            background-color: #1a1a1a;
            color: #f0f0f0;
            font-weight: 600;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Tombol Pesan */
        .btn-order {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #1a1a1a;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.8rem 1.5rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-order:hover {
            background-color: #b39330;
            border-color: #b39330;
            color: #1a1a1a;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <div class="product-detail-card">
            <div class="row g-0">
                {{-- Kolom Gambar --}}
                <div class="col-md-6">
                    {{-- PERBAIKAN: Menggunakan $product->image_url dan asset() --}}
                    <img src="{{ asset($product->image_url) }}" class="product-image-main" alt="{{ $product->name }}">
                </div>

                {{-- Kolom Detail & Form Pemesanan --}}
                <div class="col-md-6 p-4 p-md-5 d-flex flex-column">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <p class="product-price my-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="product-stock">Stok Tersedia: {{ $product->stock }} unit</p>

                    <hr style="border-color: #444;">

                    <p class="product-description text-muted">{{ $product->description }}</p>

                    {{-- Form Pemesanan --}}
                    <div class="mt-auto">
                        {{-- PERBAIKAN: Mengarahkan form ke rute 'member.cart.store' --}}
                        <form action="{{ route('member.cart.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="row">
                                {{-- Pilihan Jumlah --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jumlah</label>
                                    <div class="quantity-selector">
                                        <button type="button" onclick="decreaseQuantity()">-</button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1"
                                            max="{{ $product->stock }}" required>
                                        <button type="button" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>

                                {{-- Upload Desain (Dihilangkan karena sudah ada di proses order) --}}
                                {{-- Catatan Tambahan (Dihilangkan karena sudah ada di proses order) --}}

                            </div>

                            <button type="submit" class="btn btn-order mt-3">
                                <i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const quantityInput = document.getElementById('quantity');
        const maxStock = parseInt(quantityInput.max);

        function decreaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        function increaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            }
        }
    </script>
@endpush
