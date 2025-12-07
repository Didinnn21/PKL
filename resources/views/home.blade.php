<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kestore.id - Custom Apparel</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Animasi Scroll Reveal */
        .reveal-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }

        .reveal-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Tombol Custom */
        .btn-primary {
            @apply inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-black bg-yellow-500 rounded-lg hover:bg-yellow-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-yellow-500/20;
        }

        .btn-secondary {
            @apply inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-zinc-800 border border-zinc-700 rounded-lg hover:bg-zinc-700 hover:border-zinc-600 transition-all duration-300;
        }

        /* Input Styles (Sama dengan Login) */
        .form-input-dark {
            @apply w-full px-4 py-3 text-white bg-[#141414] border border-[#333] rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all duration-300 placeholder-gray-500;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #eab308; }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-black text-white antialiased selection:bg-yellow-500 selection:text-black">

    {{-- Navigation Bar --}}
    <header x-data="{ navOpen: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="{ 'bg-black/90 backdrop-blur-md border-b border-white/10 shadow-lg': scrolled, 'bg-transparent': !scrolled }"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore Logo" class="h-10 w-auto transition-transform group-hover:scale-105">
                        <span class="text-xl font-bold tracking-tight text-white hidden sm:block">
                            KESTORE<span class="text-yellow-500">.ID</span>
                        </span>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#koleksi" class="text-sm font-medium text-gray-300 hover:text-yellow-500 transition-colors">KOLEKSI</a>
                    <a href="#custom-order" class="text-sm font-medium text-gray-300 hover:text-yellow-500 transition-colors">CUSTOM ORDER</a>
                    <a href="#tentang-kami" class="text-sm font-medium text-gray-300 hover:text-yellow-500 transition-colors">TENTANG KAMI</a>
                    <a href="#faq" class="text-sm font-medium text-gray-300 hover:text-yellow-500 transition-colors">FAQ</a>
                </nav>

                {{-- Auth Buttons --}}
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-yellow-500 transition-colors px-4">Login</a>
                        <ster href="{{ route('register') }}" class="btn-primary">Register</ster>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden flex items-center">
                    <button @click="navOpen = !navOpen" class="text-gray-300 hover:text-white p-2 focus:outline-none">
                        <i data-lucide="menu" class="w-6 h-6" x-show="!navOpen"></i>
                        <i data-lucide="x" class="w-6 h-6" x-show="navOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Overlay --}}
        <div x-show="navOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @click.away="navOpen = false"
             class="absolute top-20 left-0 right-0 bg-zinc-900 border-b border-white/10 md:hidden shadow-2xl"
             x-cloak>

            <div class="flex flex-col p-4 space-y-2">
                <a href="#koleksi" @click="navOpen = false" class="text-base font-medium text-gray-300 hover:text-yellow-500 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors">KOLEKSI</a>
                <a href="#custom-order" @click="navOpen = false" class="text-base font-medium text-gray-300 hover:text-yellow-500 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors">CUSTOM ORDER</a>
                <a href="#tentang-kami" @click="navOpen = false" class="text-base font-medium text-gray-300 hover:text-yellow-500 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors">TENTANG KAMI</a>
                <a href="#faq" @click="navOpen = false" class="text-base font-medium text-gray-300 hover:text-yellow-500 hover:bg-white/5 px-4 py-3 rounded-lg transition-colors">FAQ</a>

                <div class="border-t border-white/10 pt-4 mt-2 flex flex-col gap-3 px-4 pb-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary w-full text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary w-full text-center">Login</a>
                        <ster href="{{ route('register') }}" class="btn-primary w-full text-center">Register</ster>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        {{-- HERO SECTION --}}
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            {{-- Background Image with Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/BG.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-50 hover:scale-105 transition-transform duration-[20s]">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-black/60"></div>
                {{-- Texture Overlay --}}
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150 mix-blend-overlay"></div>
            </div>

            {{-- Hero Content --}}
            <div class="relative z-10 container mx-auto px-4 text-center">
                <div class="reveal-card">
                    <span class="inline-block py-1 px-3 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 text-xs font-bold tracking-widest uppercase mb-6">
                        Premium Custom Apparel
                    </span>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                        Wujudkan Desain <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-600">Impianmu</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Platform pembuatan pakaian custom terbaik dengan kualitas premium. Buat hoodie, kaos, dan jaket sesuai keinginanmu tanpa batas minimum order.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="#custom-order" class="btn-primary text-base px-8 py-4 shadow-lg shadow-yellow-500/20">
                            Pesan Sekarang
                        </a>
                        <a href="#koleksi" class="btn-secondary text-base px-8 py-4">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>

                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="mt-8 mx-auto max-w-md bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-4 rounded-lg backdrop-blur-md flex items-center gap-3 reveal-card animate-bounce">
                        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
            </div>
        </section>

        {{-- ABOUT US SECTION --}}
        <section id="tentang-kami" class="py-24 bg-black relative overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    {{-- Image Grid --}}
                    <div class="reveal-card relative group">
                        <div class="absolute -inset-4 bg-yellow-500/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-40 transition duration-500"></div>
                        <img src="{{ asset('images/P-Hoodie.jpg') }}" alt="Tentang Kami" class="relative rounded-2xl shadow-2xl border border-white/10 w-full h-auto object-cover transform transition duration-500 group-hover:scale-[1.02]">
                    </div>

                    {{-- Text Content --}}
                    <div class="reveal-card">
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Tentang <span class="text-yellow-500">Kestore.id</span></h2>
                        <div class="space-y-6 text-gray-400 text-lg leading-relaxed">
                            <p>
                                Kestore.id adalah brand lokal custom apparel yang berdiri sejak 2021. Kami hadir untuk menjawab kebutuhan fashion yang personal dan unik.
                            </p>
                            <p>
                                Didirikan oleh Deki Muhamad F.R., kami berkomitmen menghadirkan kaos, hoodie, dan crewneck dengan standar kualitas distro namun dengan kebebasan desain sepenuhnya di tangan Anda.
                            </p>
                            <ul class="space-y-3 mt-4">
                                <li class="flex items-center gap-3 text-white">
                                    <div class="p-1 rounded-full bg-yellow-500/20 text-yellow-500"><i data-lucide="check" class="w-4 h-4"></i></div>
                                    Bahan Premium (Cotton Combed & Fleece)
                                </li>
                                <li class="flex items-center gap-3 text-white">
                                    <div class="p-1 rounded-full bg-yellow-500/20 text-yellow-500"><i data-lucide="check" class="w-4 h-4"></i></div>
                                    Sablon DTF & Plastisol High Quality
                                </li>
                                <li class="flex items-center gap-3 text-white">
                                    <div class="p-1 rounded-full bg-yellow-500/20 text-yellow-500"><i data-lucide="check" class="w-4 h-4"></i></div>
                                    Jahitan Rapi Standar Distro
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ADVANTAGES SECTION --}}
        <section id="keunggulan" class="py-24 bg-zinc-900/30 border-y border-white/5">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-16 reveal-card">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Kenapa Memilih Kami?</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">Kami tidak hanya menjual pakaian, kami memberikan kualitas dan kepuasan dalam setiap jahitan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="reveal-card bg-[#0a0a0a] p-8 rounded-2xl border border-white/5 hover:border-yellow-500/30 transition-colors duration-300 group hover:shadow-xl hover:shadow-yellow-500/5">
                        <div class="w-14 h-14 bg-zinc-800 rounded-xl flex items-center justify-center mb-6 group-hover:bg-yellow-500 transition-colors duration-300">
                            <i data-lucide="gem" class="w-7 h-7 text-yellow-500 group-hover:text-black transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Bahan Premium</h3>
                        <p class="text-gray-400 leading-relaxed text-sm">
                            Kami hanya menggunakan material terbaik seperti Cotton Fleece 280gsm dan Combed 30s yang nyaman, adem, dan awet.
                        </p>
                    </div>

                    <div class="reveal-card bg-[#0a0a0a] p-8 rounded-2xl border border-white/5 hover:border-yellow-500/30 transition-colors duration-300 group hover:shadow-xl hover:shadow-yellow-500/5">
                        <div class="w-14 h-14 bg-zinc-800 rounded-xl flex items-center justify-center mb-6 group-hover:bg-yellow-500 transition-colors duration-300">
                            <i data-lucide="layers" class="w-7 h-7 text-yellow-500 group-hover:text-black transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Sablon Modern</h3>
                        <p class="text-gray-400 leading-relaxed text-sm">
                            Teknologi sablon DTF (Direct Transfer Film) untuk detail presisi dan Plastisol untuk ketahanan maksimal.
                        </p>
                    </div>

                    <div class="reveal-card bg-[#0a0a0a] p-8 rounded-2xl border border-white/5 hover:border-yellow-500/30 transition-colors duration-300 group hover:shadow-xl hover:shadow-yellow-500/5">
                        <div class="w-14 h-14 bg-zinc-800 rounded-xl flex items-center justify-center mb-6 group-hover:bg-yellow-500 transition-colors duration-300">
                            <i data-lucide="sparkles" class="w-7 h-7 text-yellow-500 group-hover:text-black transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Tanpa Minimum Order</h3>
                        <p class="text-gray-400 leading-relaxed text-sm">
                            Bebas berekspresi! Pesan satuan untuk koleksi pribadi atau lusinan untuk komunitasmu. Kami siap melayani.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- COLLECTIONS SECTION --}}
        <section id="koleksi" class="py-24 bg-black">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-16 reveal-card">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">KOLEKSI KAMI</h2>
                    <p class="text-gray-400 mt-2">Temukan produk yang sesuai dengan gayamu.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($products as $product)
                        <div class="reveal-card group bg-[#0a0a0a] rounded-2xl overflow-hidden border border-white/5 hover:border-yellow-500/30 transition-all duration-300 hover:shadow-xl">
                            {{-- Image Container --}}
                            <div class="relative overflow-hidden h-80 bg-zinc-900">
                                <img src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60"></div>

                                {{-- Price Badge --}}
                                <div class="absolute top-4 right-4 bg-yellow-500 text-black font-bold text-sm px-3 py-1 rounded-full shadow-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-yellow-500 transition-colors">{{ $product->name }}</h3>
                                <p class="text-gray-400 text-sm mb-6 line-clamp-2">{{ $product->description }}</p>

                                <a href="{{ route('product.detail', $product->id) }}" class="block w-full py-3 text-center rounded-lg border border-yellow-500 text-yellow-500 font-bold hover:bg-yellow-500 hover:text-black transition-all duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-12 text-gray-500 reveal-card">
                        <i data-lucide="package-open" class="w-16 h-16 mx-auto mb-4 opacity-50"></i>
                        <p>Belum ada produk yang ditampilkan saat ini.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- FAQ SECTION --}}
        <section id="faq" class="py-24 bg-zinc-900/30 border-t border-white/5">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-16 reveal-card">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Tanya Jawab</h2>
                    <p class="text-gray-400">Temukan jawaban dari pertanyaan yang sering diajukan.</p>
                </div>

                <div class="max-w-3xl mx-auto space-y-4" x-data="{ open: 1 }">
                    <div class="reveal-card bg-[#0a0a0a] rounded-xl border border-white/5 overflow-hidden transition-all duration-300" :class="{ 'border-yellow-500/30': open === 1 }">
                        <button @click="open = (open === 1 ? 0 : 1)" class="w-full text-left p-5 flex justify-between items-center hover:bg-white/5 transition-colors">
                            <span class="font-bold text-white text-lg">Apakah bisa memesan satuan?</span>
                            <i data-lucide="chevron-down" class="transition-transform duration-300 text-yellow-500" :class="{ 'rotate-180': open === 1 }"></i>
                        </button>
                        <div x-show="open === 1" x-collapse class="px-5 pb-5 text-gray-400 leading-relaxed border-t border-white/5 pt-4">
                            <p>Tentu saja! Kami melayani pemesanan satuan tanpa minimum order. Sangat cocok untuk kamu yang ingin punya apparel eksklusif atau sebagai hadiah spesial.</p>
                        </div>
                    </div>

                    <div class="reveal-card bg-[#0a0a0a] rounded-xl border border-white/5 overflow-hidden transition-all duration-300" :class="{ 'border-yellow-500/30': open === 2 }">
                        <button @click="open = (open === 2 ? 0 : 2)" class="w-full text-left p-5 flex justify-between items-center hover:bg-white/5 transition-colors">
                            <span class="font-bold text-white text-lg">Berapa lama proses pengerjaannya?</span>
                            <i data-lucide="chevron-down" class="transition-transform duration-300 text-yellow-500" :class="{ 'rotate-180': open === 2 }"></i>
                        </button>
                        <div x-show="open === 2" x-collapse class="px-5 pb-5 text-gray-400 leading-relaxed border-t border-white/5 pt-4">
                            <p>Proses pengerjaan normalnya memakan waktu 3-7 hari kerja, tergantung pada kerumitan desain dan antrian produksi kami. Kami selalu berusaha secepat mungkin.</p>
                        </div>
                    </div>

                    <div class="reveal-card bg-[#0a0a0a] rounded-xl border border-white/5 overflow-hidden transition-all duration-300" :class="{ 'border-yellow-500/30': open === 3 }">
                        <button @click="open = (open === 3 ? 0 : 3)" class="w-full text-left p-5 flex justify-between items-center hover:bg-white/5 transition-colors">
                            <span class="font-bold text-white text-lg">Jenis sablon apa yang digunakan?</span>
                            <i data-lucide="chevron-down" class="transition-transform duration-300 text-yellow-500" :class="{ 'rotate-180': open === 3 }"></i>
                        </button>
                        <div x-show="open === 3" x-collapse class="px-5 pb-5 text-gray-400 leading-relaxed border-t border-white/5 pt-4">
                            <p>Untuk pesanan satuan kami menggunakan teknologi DTF (Direct to Film) yang detail dan awet. Untuk pesanan lusinan (12+ pcs), kami menyediakan opsi sablon Plastisol.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- CUSTOM ORDER SECTION --}}
        <section id="custom-order" class="py-24 bg-black border-t border-white/5">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-16 reveal-card">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pesan Produk Custom</h2>
                    <p class="text-gray-400 mt-2">Punya desain sendiri? Buat produk impianmu dengan mudah di sini.</p>
                </div>

                {{-- Alert Errors --}}
                @if ($errors->any())
                    <div class="max-w-3xl mx-auto bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg mb-8 reveal-card">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- CEK AUTH --}}
                @auth
                    <div class="max-w-3xl mx-auto bg-[#0a0a0a] p-8 md:p-10 rounded-2xl shadow-2xl border border-white/10 reveal-card relative overflow-hidden">
                        {{-- Decorative Glow --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 blur-3xl rounded-full pointer-events-none"></div>

                        <form action="{{ route('custom.order') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Judul Pesanan / Nama Produk</label>
                                <input type="text" id="name" name="name" class="form-input-dark" placeholder="Contoh: Hoodie Angkatan 2024 - Size L" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-300 mb-2">Jumlah</label>
                                    <input type="number" id="quantity" name="quantity" min="1" class="form-input-dark" placeholder="1" required>
                                </div>
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Unggah Desain (JPG/PNG)</label>
                                    <input type="file" id="image" name="image" class="w-full text-sm text-gray-400 bg-[#141414] border border-[#333] rounded-lg cursor-pointer focus:outline-none file:mr-4 file:py-3 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-bold file:bg-zinc-800 file:text-white hover:file:bg-zinc-700 transition" required>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Detail Spesifikasi</label>
                                <textarea id="description" name="description" rows="4" class="form-input-dark" placeholder="Jelaskan detail warna kain, ukuran sablon, posisi sablon, dan request lainnya..." required></textarea>
                            </div>

                            <div class="pt-4 text-center">
                                <button type="submit" class="btn-primary w-full md:w-auto px-10 py-3 text-base shadow-lg shadow-yellow-500/20">
                                    Kirim Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    {{-- Lock Screen for Guest --}}
                    <div class="max-w-2xl mx-auto bg-[#0a0a0a] border border-white/10 p-10 rounded-2xl text-center reveal-card shadow-2xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-zinc-900 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/5">
                                <i data-lucide="lock" class="h-10 w-10 text-yellow-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-3">Akses Terbatas</h3>
                            <p class="text-gray-400 mb-8 max-w-md mx-auto">Anda harus login terlebih dahulu untuk melakukan pemesanan custom. Silakan login atau registrasi akun baru.</p>
                            <div class="flex flex-col sm:flex-row justify-center gap-4">
                                <a href="{{ route('login') }}" class="btn-primary w-full sm:w-auto px-8">Login</a>
                                <a href="{{ route('register') }}" class="btn-secondary w-full sm:w-auto px-8">Daftar Akun</a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </section>

    </main>

    {{-- Footer --}}
<footer class="bg-[#050505] pt-16 pb-8 border-t border-white/10">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left mb-12">
            
            <div class="space-y-4">
                <h3 class="text-2xl font-bold text-white tracking-tight">
                    KESTORE<span class="text-yellow-500">.ID</span>
                </h3>
                <p class="text-sm text-gray-400 leading-relaxed max-w-xs mx-auto md:mx-0">
                    Spesialis custom apparel untuk gaya unikmu. Kualitas premium, desain tanpa batas, dan pelayanan terbaik untuk kepuasan Anda.
                </p>
            </div>

            <div class="space-y-4">
                <h3 class="font-bold text-white text-lg">Lokasi Kami</h3>
                <div class="text-sm text-gray-400 leading-relaxed space-y-2">
                    <p>Komplek Margaasih Permai,</p>
                    <p>Jl. Sedap Malam No.22 blok U1, RT.04/RW.19,</p>
                    <p>Margaasih, Kab. Bandung, Jawa Barat 40215</p>
                </div>
                <a href="https://maps.google.com/?q=Komplek+Margaasih+Permai" target="_blank" 
                   class="inline-flex items-center text-yellow-500 hover:text-yellow-400 text-sm font-bold transition-colors mt-2 group">
                    Lihat di Google Maps 
                    <i data-lucide="arrow-up-right" class="w-4 h-4 ml-1 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"></i>
                </a>
            </div>

            <div class="space-y-4">
                <h3 class="font-bold text-white text-lg">Ikuti Kami</h3>
                <p class="text-sm text-gray-400">Dapatkan info promo dan desain terbaru.</p>
                <div class="flex justify-center md:justify-start gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-900 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-900 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-2.43.03-4.83-.95-6.46-2.9-1.6-1.92-2.3-4.43-1.8-6.83.47-2.31 1.98-4.25 3.98-5.46 2.02-1.2 4.54-1.42 6.74-1.02.01 2.38-.01 4.75.02 7.12-.52-.15-1.03-.3-1.52-.47-1.42-.48-2.9-.8-4.27-1.15.28-2.26.88-4.4 2.15-6.19C10.22 2.12 11.33.91 12.525.02z"></path></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-900 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all duration-300">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 pt-8 text-center">
            <p class="text-sm text-zinc-500">
                &copy; {{ date('Y') }} <span class="text-white font-semibold">Kestore.id</span>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

    {{-- Script untuk Icon dan Scroll Animation --}}
    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', () => {
            const intersectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.reveal-card').forEach(card => {
                intersectionObserver.observe(card);
            });
        });
    </script>
</body>
</html>
