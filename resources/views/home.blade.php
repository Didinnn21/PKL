<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kestore.id - Your Style, Indescribable</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #111111;
            color: #e0e0e0;
        }

        .gold-gradient-text {
            background: linear-gradient(45deg, #d4af37, #a08153);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gold {
            background: linear-gradient(45deg, #d4af37, #b39330);
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        .glass-card {
            background: rgba(26, 26, 26, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-bg {
            background-image: linear-gradient(to top, #111111 20%, rgba(17, 17, 17, 0.5)), url('{{ asset('images/Slide-1.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body x-data="{ activeCategory: 'all', mobileMenuOpen: false }">

    <header class="sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 py-4 flex justify-between items-center glass-card rounded-b-2xl">
            <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo" class="h-8 w-8 rounded-md">
                <span class="text-xl font-bold text-white">KESTORE.ID</span>
            </a>
            <div class="hidden md:flex items-center space-x-6">
                <a href="#koleksi" class="text-gray-300 hover:text-white transition">Koleksi</a>
                <a href="#proses" class="text-gray-300 hover:text-white transition">Proses</a>
                <a href="#testimoni" class="text-gray-300 hover:text-white transition">Testimoni</a>
            </div>
            <div class="hidden md:flex items-center space-x-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-gray-300 hover:text-white transition hidden sm:block">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-gray-800 font-semibold px-5 py-2 rounded-full btn-gold">Register</a>
                @else
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-gray-800 font-semibold px-5 py-2 rounded-full btn-gold">My Dashboard</a>
                @endguest
            </div>
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white focus:outline-none">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </div>
        </nav>
    </header>

    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
        class="md:hidden fixed inset-0 bg-black bg-opacity-90 z-40"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="flex flex-col items-center justify-center h-full space-y-6 text-xl">
            <a @click="mobileMenuOpen = false" href="#koleksi"
                class="text-gray-300 hover:text-white transition">Koleksi</a>
            <a @click="mobileMenuOpen = false" href="#proses"
                class="text-gray-300 hover:text-white transition">Proses</a>
            <a @click="mobileMenuOpen = false" href="#testimoni"
                class="text-gray-300 hover:text-white transition">Testimoni</a>
            <div class="pt-6 flex flex-col items-center space-y-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-gray-800 font-semibold px-6 py-3 rounded-full btn-gold">Register</a>
                @else
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-gray-800 font-semibold px-6 py-3 rounded-full btn-gold">My Dashboard</a>
                @endguest
            </div>
        </div>
    </div>


    <main>
        <section class="relative min-h-screen flex items-center justify-center text-center hero-bg py-24">
            <div class="px-4 sm:px-6">
                <h1
                    class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight animate-fade-in-up">
                    YOUR STYLE, <br> <span class="gold-gradient-text">INDESCRIBABLE.</span>
                </h1>
                <p class="mt-6 text-base sm:text-lg md:text-xl text-gray-300 max-w-2xl mx-auto">
                    Ekspresikan dirimu tanpa batas. Kami wujudkan setiap desain streetwear impianmu menjadi kenyataan
                    dengan kualitas premium.
                </p>
                <div class="mt-10">
                    <a href="#koleksi"
                        class="text-gray-800 font-bold text-base sm:text-lg px-6 py-3 sm:px-8 sm:py-4 rounded-full btn-gold">
                        Lihat Koleksi Kami
                    </a>
                </div>
            </div>
        </section>

        <section id="koleksi" class="py-20 sm:py-24 md:py-32">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white">Koleksi Unggulan</h2>
                    <p class="mt-4 text-gray-400">Pilih kategori atau jelajahi semua produk custom terbaik kami.</p>
                </div>

                <div class="flex justify-center space-x-2 md:space-x-4 mb-10">
                    <button @click="activeCategory = 'all'"
                        :class="{ 'bg-yellow-500 text-black': activeCategory === 'all', 'bg-gray-800 text-gray-300': activeCategory !== 'all' }"
                        class="px-5 py-2 rounded-full font-semibold transition">Semua</button>
                    <button @click="activeCategory = 'hoodie'"
                        :class="{ 'bg-yellow-500 text-black': activeCategory === 'hoodie', 'bg-gray-800 text-gray-300': activeCategory !== 'hoodie' }"
                        class="px-5 py-2 rounded-full font-semibold transition">Hoodie</button>
                    <button @click="activeCategory = 'crewneck'"
                        :class="{ 'bg-yellow-500 text-black': activeCategory === 'crewneck', 'bg-gray-800 text-gray-300': activeCategory !== 'crewneck' }"
                        class="px-5 py-2 rounded-full font-semibold transition">Crewneck</button>
                    <button @click="activeCategory = 'kaos'"
                        :class="{ 'bg-yellow-500 text-black': activeCategory === 'kaos', 'bg-gray-800 text-gray-300': activeCategory !== 'kaos' }"
                        class="px-5 py-2 rounded-full font-semibold transition">Kaos</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        if (isset($products)) {
                            $products->each(function ($product) {
                                if (stripos($product->name, 'Hoodie') !== false)
                                    $product->category = 'hoodie';
                                elseif (stripos($product->name, 'Crewneck') !== false)
                                    $product->category = 'crewneck';
                                elseif (stripos($product->name, 'Kaos') !== false)
                                    $product->category = 'kaos';
                                else
                                    $product->category = 'lainnya';
                            });
                        }
                    @endphp

                    @forelse($products ?? [] as $product)
                        <div class="reveal-card"
                            x-show="activeCategory === 'all' || activeCategory === '{{ $product->category }}'" x-transition>
                            <a href="{{ route('product.detail', $product->id) }}" class="block group">
                                <div class="overflow-hidden rounded-2xl">
                                    <img src="{{ asset($product->image_url ?? 'https://placehold.co/600x600/111111/FFFFFF/png?text=KESTORE.ID') }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-96 object-cover transform group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="mt-4">
                                    <h3 class="text-xl font-semibold text-white">{{ $product->name }}</h3>
                                    <p class="text-lg font-bold gold-gradient-text mt-1">Rp
                                        {{ number_format($product->price) }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 col-span-full">Belum ada produk untuk ditampilkan.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="proses" class="py-20 sm:py-24 md:py-32 bg-black">
            <div class="container mx-auto px-4 sm:px-6 text-center">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white">3 Langkah Mudah Menuju Gayamu</h2>
                <p class="mt-4 text-gray-400 max-w-2xl mx-auto">Dari ide hingga menjadi nyata, prosesnya semudah ini.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-16">
                    <div class="reveal-card">
                        <div
                            class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-gray-800 border-2 border-yellow-500 text-4xl font-bold gold-gradient-text">
                            1</div>
                        <h3 class="text-2xl font-semibold mt-6 text-white">Pilih & Desain</h3>
                        <p class="text-gray-400 mt-2">Pilih produk favoritmu, lalu unggah desain keren yang sudah kamu
                            siapkan.</p>
                    </div>
                    <div class="reveal-card">
                        <div
                            class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-gray-800 border-2 border-yellow-500 text-4xl font-bold gold-gradient-text">
                            2</div>
                        <h3 class="text-2xl font-semibold mt-6 text-white">Konfirmasi & Bayar</h3>
                        <p class="text-gray-400 mt-2">Selesaikan pembayaran dengan mudah dan aman. Tim kami akan segera
                            memproses pesananmu.</p>
                    </div>
                    <div class="reveal-card">
                        <div
                            class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-gray-800 border-2 border-yellow-500 text-4xl font-bold gold-gradient-text">
                            3</div>
                        <h3 class="text-2xl font-semibold mt-6 text-white">Terima & Pamerkan</h3>
                        <p class="text-gray-400 mt-2">Produk custom impianmu akan tiba di depan pintu. Saatnya tampil
                            beda!</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="py-20 sm:py-24 md:py-32">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white">Kata Mereka Tentang Kami</h2>
                    <p class="mt-4 text-gray-400">Kepuasan pelanggan adalah bukti kualitas kami.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="reveal-card glass-card p-8 rounded-2xl">
                        <p class="text-gray-300">"Kualitas sablonnya juara! Warnanya tajam dan gak luntur. Bahannya juga
                            adem banget. Pasti order lagi di sini."</p>
                        <div class="flex items-center mt-6">
                            <div class="font-semibold text-white">- Andi B., Jakarta</div>
                        </div>
                    </div>
                    <div class="reveal-card glass-card p-8 rounded-2xl">
                        <p class="text-gray-300">"Pelayanannya cepat dan ramah. Adminnya sangat membantu waktu
                            konsultasi desain. Hasilnya persis seperti yang saya mau. Keren!"</p>
                        <div class="flex items-center mt-6">
                            <div class="font-semibold text-white">- Citra L., Bandung</div>
                        </div>
                    </div>
                    <div class="reveal-card glass-card p-8 rounded-2xl">
                        <p class="text-gray-300">"Akhirnya nemu tempat custom hoodie satuan yang kualitasnya gak
                            main-main. Harganya juga bersahabat. Recommended!"</p>
                        <div class="flex items-center mt-6">
                            <div class="font-semibold text-white">- Doni S., Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="glass-card rounded-2xl p-10 md:p-16 text-center">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white">Punya Ide Gila?</h2>
                    <p class="mt-4 text-gray-300 max-w-2xl mx-auto">Jangan biarkan idemu hanya menjadi angan-angan.
                        Wujudkan sekarang bersama kami dan ciptakan gayamu sendiri!</p>
                    <div class="mt-8">
                        <a href="{{ route('register') }}"
                            class="text-gray-800 font-bold text-lg px-8 py-4 rounded-full btn-gold inline-block">
                            Mulai Kreasikan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-black py-10">
        <div class="container mx-auto px-6 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Kestore.id. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        const sr = ScrollReveal({
            distance: '50px',
            duration: 1500,
            easing: 'cubic-bezier(0.5, 0, 0, 1)',
            reset: false,
        });

        sr.reveal('.animate-fade-in-up', {
            origin: 'bottom',
            delay: 200,
        });

        sr.reveal('.reveal-card', {
            origin: 'bottom',
            interval: 200,
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
