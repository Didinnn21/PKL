<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kestore.id - Custom Streetwear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        .carousel-caption h5 {
            font-size: 2.5rem;
            font-weight: 700;
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

        .btn-outline-gold {
            border-color: #d4af37;
            color: #d4af37;
            font-weight: 600;
        }

        .btn-outline-gold:hover {
            background-color: #d4af37;
            color: #1a1a1a;
        }

        /* STYLE UNTUK BAGIAN BARU */
        .section-title {
            color: #d4af37;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: #ccc;
            margin-bottom: 3rem;
        }

        .feature-box, .step-box, .testimonial-card {
            background-color: #252525;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #333;
            text-align: center;
            height: 100%;
        }

        .feature-box .icon, .step-box .icon {
            font-size: 3rem;
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .cta-section {
            background-color: #252525;
            padding: 4rem 2rem;
            border-radius: 8px;
            text-align: center;
        }

        footer {
            background-color: #252525;
            padding: 2rem 0;
            margin-top: 4rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
                <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo" style="height: 30px; margin-right: 8px; border-radius: 4px;">
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
                            <button type="submit" class="btn btn-link text-decoration-none" style="color: #d4af37 !important; font-weight: 600;">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <header>
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
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
                    <img src="{{ asset('images/Slide-3.png') }}" class="d-block w-100" alt="Informasi Hoodie Custom Kestore.id">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Wujudkan Desain Hoodie-mu.</h5>
                        <p>Custom satuan dengan sablon DTF berkualitas tinggi. Hubungi kami!</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
        </div>
    </header>

    <main class="container py-5">
        <h2 class="text-center section-title">Produk Unggulan</h2>
        <p class="text-center section-subtitle">Temukan produk custom terbaik kami yang siap menjadi milikmu.</p>
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card product-card text-white">
                        <img src="{{ $product->image_url ?? 'https://placehold.co/300x300/252525/FFFFFF/png?text=Gambar+Produk' }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text fw-bold">Rp {{ number_format($product->price) }}</p>
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-gold w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><p class="text-center text-muted">Belum ada produk.</p></div>
            @endforelse
        </div>
    </main>

    <!-- BAGIAN BARU: KEUNGGULAN KAMI -->
    <div class="container py-5">
        <h2 class="text-center section-title">Kenapa Memilih Kestore.id?</h2>
        <p class="text-center section-subtitle">Kami memberikan lebih dari sekadar pakaian, kami memberikan kualitas dan pengalaman.</p>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="feature-box">
                    <div class="icon"><i class="fas fa-tshirt"></i></div>
                    <h5>Bahan Premium</h5>
                    <p class="text-muted">Menggunakan bahan katun kombat berkualitas tinggi yang nyaman dan tahan lama.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box">
                    <div class="icon"><i class="fas fa-palette"></i></div>
                    <h5>Desain Fleksibel</h5>
                    <p class="text-muted">Bebas wujudkan idemu. Unggah desainmu sendiri dan biarkan kami mencetaknya.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box">
                    <div class="icon"><i class="fas fa-shipping-fast"></i></div>
                    <h5>Proses Cepat</h5>
                    <p class="text-muted">Proses produksi yang efisien memastikan pesananmu selesai tepat waktu.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box">
                    <div class="icon"><i class="fas fa-box"></i></div>
                    <h5>Tanpa Minimum Order</h5>
                    <p class="text-muted">Pesan untuk dirimu sendiri atau dalam jumlah besar, kami siap melayani.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN BARU: CARA PEMESANAN -->
    <div class="container py-5">
        <h2 class="text-center section-title">Cara Pemesanan</h2>
        <p class="text-center section-subtitle">Hanya butuh 3 langkah mudah untuk mendapatkan produk custom impianmu.</p>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="step-box">
                    <div class="icon">1</div>
                    <h5>Pilih Produk</h5>
                    <p class="text-muted">Pilih jenis pakaian (kaos, hoodie, dll.) yang ingin kamu custom.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="step-box">
                    <div class="icon">2</div>
                    <h5>Upload Desain</h5>
                    <p class="text-muted">Unggah file desain terbaikmu dan tambahkan catatan jika diperlukan.</p>
                </div>
            </div>
             <div class="col-md-4 mb-4">
                <div class="step-box">
                    <div class="icon">3</div>
                    <h5>Bayar & Tunggu</h5>
                    <p class="text-muted">Selesaikan pembayaran dan tunggu produk kerenmu tiba di depan pintu.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN BARU: TESTIMONI -->
    <div class="container py-5">
         <h2 class="text-center section-title">Kata Mereka Tentang Kami</h2>
         <p class="text-center section-subtitle">Kepuasan pelanggan adalah prioritas utama kami.</p>
         <div class="row">
             <div class="col-md-4 mb-4">
                 <div class="testimonial-card">
                     <p class="fst-italic">"Kualitas sablonnya juara! Warnanya tajam dan gak luntur. Bahannya juga adem banget. Pasti order lagi di sini."</p>
                     <p class="fw-bold mt-3 mb-0">- Andi B., Jakarta</p>
                 </div>
             </div>
              <div class="col-md-4 mb-4">
                 <div class="testimonial-card">
                     <p class="fst-italic">"Pelayanannya cepat dan ramah. Adminnya sangat membantu waktu konsultasi desain. Hasilnya persis seperti yang saya mau. Keren!"</p>
                     <p class="fw-bold mt-3 mb-0">- Citra L., Bandung</p>
                 </div>
             </div>
              <div class="col-md-4 mb-4">
                 <div class="testimonial-card">
                     <p class="fst-italic">"Akhirnya nemu tempat custom hoodie satuan yang kualitasnya gak main-main. Harganya juga bersahabat. Recommended!"</p>
                     <p class="fw-bold mt-3 mb-0">- Doni S., Surabaya</p>
                 </div>
             </div>
         </div>
    </div>

    <!-- BAGIAN BARU: CALL TO ACTION -->
    <div class="container py-5">
        <div class="cta-section">
            <h2 class="section-title">Punya Ide Desain?</h2>
            <p class="section-subtitle lead">Jangan biarkan idemu hanya menjadi angan-angan. Wujudkan sekarang bersama kami!</p>
            <a href="{{ route('landing') }}#products" class="btn btn-warning btn-lg">Lihat Semua Produk</a>
        </div>
    </div>

    <footer>
        <div class="container text-center text-muted">
            <p>&copy; {{ date('Y') }} Kestore.id. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

