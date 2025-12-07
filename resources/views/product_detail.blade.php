@extends('layouts.app')

@section('title', $product->name)

@push('styles')
    {{-- Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .product-container {
            max-width: 800px;
            margin: auto;
        }

        .product-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .product-image-wrapper {
            background-color: #000;
            padding: 1rem;
        }

        .product-image {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 10px;
        }

        .product-info {
            padding: 2rem;
        }

        .product-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #fff;
        }

        .product-price {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--primary-gold);
        }

        .stock-badge {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4em 0.8em;
            border-radius: 20px;
        }

        .product-description {
            color: var(--text-muted);
            line-height: 1.8;
        }

        .spec-list {
            list-style: none;
            padding-left: 0;
            color: var(--text-muted);
        }

        .spec-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--dark-border);
            display: flex;
            justify-content: space-between;
        }

        .spec-list li strong {
            color: var(--text-light);
        }

        /* PERBAIKAN: Form Pemesanan dibungkus card gold */
        .order-form-container {
            background: linear-gradient(145deg, #e6b438, #c8a02a);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #d4af37;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.25);
        }

        .order-form-container .form-label {
            color: #2c2c2c;
            /* Warna gelap agar kontras dengan background gold */
        }

        .quantity-selector button {
            background-color: #fff;
            color: #2c2c2c;
            border: 1px solid #c8a02a;
        }

        .quantity-selector button:hover {
            background-color: #f0f0f0;
            color: #000;
        }

        .quantity-selector input {
            text-align: center;
            border-top: 1px solid #c8a02a;
            border-bottom: 1px solid #c8a02a;
            border-left: none;
            border-right: none;
            background-color: #fff;
            color: #1a1a1a;
            /* PERBAIKAN: Warna font jumlah menjadi gelap */
            font-weight: 700;
            -moz-appearance: textfield;
        }

        .btn-order {
            background-color: #2c2c2c;
            border-color: #2c2c2c;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-order:hover {
            background-color: #1a1a1a;
            border-color: #1a1a1a;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    <div class="container product-container my-5">
        <div class="product-card">
            {{-- Bagian Gambar --}}
            <div class="product-image-wrapper">
                <img src="{{ asset($product->image_url ?? 'https://placehold.co/800x600/000000/FFFFFF/png?text=Gambar+Produk') }}"
                    class="product-image" alt="{{ $product->name }}">
            </div>

            {{-- Bagian Informasi & Form --}}
            <div class="product-info">
                {{-- Nama & Stok --}}
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <span class="stock-badge mt-2">Stok: {{ $product->stock }}</span>
                </div>

                {{-- Harga --}}
                <p class="product-price mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                {{-- Deskripsi --}}
                <h5 class="text-white fw-bold">Deskripsi</h5>
                <p class="product-description">{{ $product->description }}</p>

                <hr class="my-4" style="border-color: var(--dark-border);">

                {{-- Spesifikasi --}}
                <h5 class="text-white fw-bold">Spesifikasi</h5>
                <ul class="spec-list">
                    <li><span>Bahan</span> <strong>Cotton Fleece 280gsm (Hoodie/Crewneck), Cotton Combed 24s (Kaos)</strong>
                    </li>
                    <li><span>Sablon Satuan</span> <strong>DTF (Direct to Film)</strong></li>
                    <li><span>Sablon Lusinan</span> <strong>Plastisol (Min. 12 pcs)</strong></li>
                    <li><span>Kualitas</span> <strong>Premium & Tahan Lama</strong></li>
                </ul>

                {{-- Form Pemesanan --}}
                <div class="order-form-container mt-4">
                    <form action="{{ route('member.cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row align-items-center g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold small">JUMLAH</label>
                                <div class="input-group quantity-selector">
                                    <button class="btn" type="button" onclick="decreaseQuantity()">-</button>
                                    <input type="number" name="quantity" id="quantity" class="form-control text-center"
                                        value="1" min="1" max="{{ $product->stock }}" required readonly>
                                    <button class="btn" type="button" onclick="increaseQuantity()">+</button>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold small">&nbsp;</label>
                                <button type="submit" class="btn btn-order w-100">
                                    <i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
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
