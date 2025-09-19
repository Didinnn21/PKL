<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kestore.id - Custom Streetwear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #1a1a1a;
            border-bottom: 1px solid #333;
        }

        .navbar-brand {
            color: #d4af37 !important;
            font-weight: 700;
        }

        .nav-link {
            color: #f0f0f0 !important;
        }

        .carousel-item {
            height: 80vh;
            min-height: 400px;
            background-color: #000;
        }

        .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: contain;
            filter: brightness(60%);
        }

        .carousel-caption {
            position: absolute;
            right: 15%;
            left: 15%;
            bottom: 1.25rem;
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
            color: #fff;
            text-align: center;
            width: 70%;
            margin: 0 auto;
        }

        .carousel-caption h5 {
            font-size: 2.5rem;
            font-weight: 700;
            bottom: 40%;
            margin: 0 auto;
        }

        .product-card {
            background-color: #252525;
            border: 1px solid #333;
            margin-bottom: 1.5rem;
            transition: transform .2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .product-card img {
            height: 300px;
            object-fit: cover;
        }

        .product-card .card-body {
            padding: 1rem;
        }

        .btn-outline-gold {
            border-color: #d4af37;
            color: #d4af37;
            font-weight: 600;
        }

        .btn-outline-gold:hover {
            background-color: #d4af37;
            color: #1a1a1a;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
                <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo"
                    style="height: 30px; margin-right: 8px;">
                KESTORE.ID
            </a>
            <div class="ms-auto">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-gold me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                @else
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-gold me-3">My Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none"
                                style="color: #d4af37 !important; font-weight: 600;">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <header>
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="{{ asset('images/Slide-1.jpg') }}" class="d-block w-100" alt="Kestore.id Lifestyle">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Your Style, Indescribable.</h5>
                        <p>Ekspresikan dirimu dengan custom apparel yang lebih dari sekadar pakaian.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('images/Slide-2.png') }}" class="d-block w-100" alt="Crewneck Custom Kestore.id">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Signature Crewneck Series.</h5>
                        <p>Desain ikonik bertemu kenyamanan premium.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('images/Slide-3.png') }}" class="d-block w-100"
                        alt="Informasi Hoodie Custom Kestore.id">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Wujudkan Desain Hoodie-mu.</h5>
                        <p>Custom satuan dengan sablon DTF berkualitas tinggi. Hubungi kami!</p>
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

    <main class="container py-5">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card product-card text-white">
                        <img src="{{ $product->image_url ?? 'https://placehold.co/300x300/252525/FFFFFF/png?text=Gambar+Produk' }}"
                            class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text fw-bold">Rp {{ number_format($product->price) }}</p>

                            {{-- PERUBAHAN DI SINI --}}
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-gold w-100">View
                                Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada produk yang tersedia saat ini. Silakan cek kembali nanti.
                    </p>
                </div>
            @endforelse
        </div>
    </main>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</html>
