@extends('layouts.app')

@section('title', $product->name)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        /* Dasar Halaman */
        .main-wrapper {
            background-color: #000;
            min-height: 100vh;
            padding: 40px 0;
            color: #fff;
            display: flex;
            align-items: center;
        }

        /* Container Produk */
        .product-card-custom {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 24px;
            overflow: hidden;
            display: flex; /* Menggunakan Flexbox untuk memisahkan kolom */
            flex-wrap: wrap;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7);
        }

        /* Bagian Kiri: Area Gambar */
        .img-area {
            flex: 1;
            min-width: 350px;
            background-color: #080808;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 1px solid #333;
            max-height: 600px; /* Batas tinggi kolom gambar */
        }

        .img-area img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Memaksa gambar mengecil dalam bingkai */
            border-radius: 12px;
        }

        /* Bagian Kanan: Area Informasi */
        .info-area {
            flex: 1.2;
            min-width: 350px;
            padding: 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #1a1a1a; /* Memastikan latar belakang teks solid */
        }

        .badge-status {
            background: rgba(212, 175, 55, 0.15);
            color: #d4af37;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            border: 1px solid rgba(212, 175, 55, 0.4);
            display: inline-block;
            margin-bottom: 20px;
        }

        .product-name {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 5px;
            line-height: 1.1;
        }

        .product-price {
            font-size: 2.2rem;
            color: #d4af37;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .section-label {
            font-size: 0.9rem;
            font-weight: 700;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .description-text {
            color: #bbb;
            line-height: 1.8;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        /* Area Form Pembelian */
        .purchase-box {
            background-color: #000;
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #d4af37;
        }

        .qty-wrapper {
            display: flex;
            align-items: center;
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 10px;
            width: fit-content;
        }

        .qty-btn {
            background: #d4af37;
            color: #000;
            border: none;
            width: 40px;
            height: 40px;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .qty-input {
            background: transparent;
            border: none;
            color: #fff;
            text-align: center;
            width: 60px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .btn-submit {
            background-color: #d4af37;
            color: #000;
            border: none;
            padding: 15px;
            font-weight: 800;
            border-radius: 10px;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #fff;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .img-area { border-right: none; border-bottom: 1px solid #333; }
            .product-name { font-size: 2rem; }
        }
    </style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="container">
        <div class="product-card-custom">

            <div class="img-area">
                <img src="{{ asset($product->image_url ?? 'storage/products/default.jpg') }}" alt="{{ $product->name }}">
            </div>

            <div class="info-area">
                <div class="badge-status">
                    <i class="fas fa-check-circle me-1"></i> Stok: {{ $product->stock }} Unit Tersedia
                </div>

                <h1 class="product-name">{{ $product->name }}</h1>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <div class="section-label">Deskripsi Produk</div>
                <p class="description-text">{{ $product->description }}</p>

                <div class="purchase-box">
                    <form action="{{ route('member.cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row align-items-center">
                            <div class="col-md-5 mb-3 mb-md-0">
                                <label class="small fw-bold text-warning mb-2 d-block text-uppercase">Tentukan Jumlah</label>
                                <div class="qty-wrapper">
                                    <button type="button" class="qty-btn" onclick="modifyQty(-1)">-</button>
                                    <input type="number" name="quantity" id="p_qty" class="qty-input" value="1" min="1" max="{{ $product->stock }}" readonly>
                                    <button type="button" class="qty-btn" onclick="modifyQty(1)">+</button>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-cart-plus me-2"></i> Tambahkan ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mt-4 text-center">
                    <small class="text-muted"><i class="fas fa-shield-alt text-warning me-1"></i> Produk Original & Kualitas Premium Kestore.id</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function modifyQty(n) {
        const field = document.getElementById('p_qty');
        let current = parseInt(field.value) + n;
        if (current >= 1 && current <= parseInt(field.max)) {
            field.value = current;
        }
    }
</script>
@endpush
