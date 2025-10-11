@extends('layouts.app')

@section('content')
<style>
    /* Hero Section with Carousel */
    .carousel-item {
        height: 100vh;
        min-height: 500px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .carousel-caption {
        bottom: 20%;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 2rem;
        border-radius: 0.5rem;
    }
    .carousel-caption h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    }
    .btn-gold {
        background-color: #d4af37;
        border-color: #d4af37;
        color: #121212;
        font-weight: 600;
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .btn-gold:hover {
        background-color: #c8a02a;
        border-color: #c8a02a;
        transform: translateY(-2px);
    }

    /* Section Styles */
    .section {
        padding: 80px 0;
    }
    .section-title {
        text-align: center;
        margin-bottom: 50px;
        font-size: 2.5rem;
        font-weight: 700;
        color: #d4af37;
    }

    /* Product Card */
    .product-card {
        background-color: #222;
        border: 1px solid #444;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.1);
    }
    .product-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .product-card .card-body {
        padding: 1.5rem;
    }
    .product-card .card-title {
        color: #d4af37;
        font-weight: 600;
    }
    .product-card .card-text {
        color: #ccc;
    }
    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
    }
</style>

<header>
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset('images/BG.jpg') }}')">
                <div class="carousel-caption text-center">
                    <h1>Temukan Gaya Terbaikmu</h1>
                    <p class="lead">Koleksi pakaian premium yang dirancang untuk kenyamanan dan gaya.</p>
                    <a href="#products" class="btn btn-gold">Lihat Produk</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/P-Hoodie.jpg') }}')">
                <div class="carousel-caption text-center">
                    <h1>Kualitas Tak Tertandingi</h1>
                    <p class="lead">Dibuat dengan bahan pilihan untuk daya tahan maksimal.</p>
                    <a href="#products" class="btn btn-gold">Belanja Sekarang</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/Slide-3.png') }}')">
                <div class="carousel-caption text-center">
                    <h1>Desain Modern & Elegan</h1>
                    <p class="lead">Tampil beda dengan koleksi eksklusif dari Kestore.id.</p>
                    <a href="#products" class="btn btn-gold">Jelajahi Koleksi</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</header>

<div id="products" class="section">
    <div class="container">
        <h2 class="section-title">Produk Unggulan Kami</h2>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100">
                        <img src="{{ $product->image_url ?? asset('images/product/default.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-custom-outline">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Saat ini belum ada produk yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
