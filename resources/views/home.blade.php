<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kestore.id</title>
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alphine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .reveal-card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .reveal-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

</head>

<body class="bg-black">
    {{-- Tombol Navigation --}}
    <div x-data="{
        navOpen: false,
        scrolled: false,
        atTop: true,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
                this.atTop = window.scrollY <= 50;
            });
        }
    }" :class="{ 'bg-black bg-opacity-70 backdrop-blur-md': scrolled, 'bg-transparent': atTop }"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="/">
                    <img src="{{ asset('images/kestore-logo.png') }}" alt="Kestore.id Logo" class="h-12 w-auto">
                </a>

                {{-- Navigasi Desktop --}}
                <nav class="hidden sm:flex items-center space-x-8">
                    <a href="#koleksi" class="text-gray-300 hover:text-white transition font-medium text-sm">KOLEKSI</a>
                    <a href="/register" class="text-gray-300 hover:text-white transition font-medium text-sm">CUSTOM
                        ORDER</a>
                    <a href="#tentang-kami"
                        class="text-gray-300 hover:text-white transition font-medium text-sm">TENTANG KAMI</a>
                    <a href="#faq" class="text-gray-300 hover:text-white transition font-medium text-sm">FAQ</a>
                </nav>

                {{-- Tombol Login dan Burger Menu --}}
                <div class="flex items-center">
                    <a href="/login"
                        class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition">
                        Login
                    </a>

                    <button @click="navOpen = !navOpen" class="sm:hidden text-white ml-4">
                        <i x-show="!navOpen" data-lucide="menu" class="h-6 w-6"></i>
                        <i x-show="navOpen" data-lucide="x" class="h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Navigasi Mobile --}}
        <div x-show="navOpen" @click.away="navOpen = false" x-transition class="sm:hidden bg-black bg-opacity-90">
            <div class="flex flex-col items-center space-y-4 py-6">
                <a href="#koleksi" @click="navOpen = false"
                    class="text-gray-300 hover:text-white transition">KOLEKSI</a>
                <a href="/register" @click="navOpen = false" class="text-gray-300 hover:text-white transition">CUSTOM
                    ORDER</a>
                <a href="#tentang-kami" @click="navOpen = false"
                    class="text-gray-300 hover:text-white transition">TENTANG
                    KAMI</a>
                <a href="#faq" @click="navOpen = false" class="text-gray-300 hover:text-white transition">FAQ</a>
                <a href="/login"
                    class="inline-flex items-center justify-center px-6 py-2 text-sm font-semibold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition">
                    Login
                </a>
            </div>
        </div>
    </div>

    <main>
        {{-- Section Hero --}}
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/Slide-1.jpg') }}" alt="Hero Background"
                    class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black"></div>
            </div>
            <div class="relative z-10 text-center text-white px-4">
                <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold mb-4 leading-tight">
                    Kestore.id
                </h1>
                <p class="text-lg sm:text-xl max-w-2xl mx-auto text-gray-300">
                    Spesialis Custom Apparel Satuan & Lusinan
                </p>
            </div>
        </section>

        {{-- Bagian Tentang Kami --}}
        <section id="tentang-kami" class="py-20 sm:py-24">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="reveal-card">
                        <img src="{{ asset('images/Slide-2.png') }}" alt="Tentang Kestore.id"
                            class="rounded-2xl shadow-lg w-full h-auto object-cover">
                    </div>
                    <div class="reveal-card">
                        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Tentang Kestore.id</h2>
                        <p class="text-gray-400 mb-4">
                            Kestore.id adalah spesialis custom apparel yang lahir dari semangat untuk mengekspresikan
                            diri. Kami percaya bahwa setiap orang berhak tampil beda dengan gaya yang unik dan
                            personal.
                        </p>
                        <p class="text-gray-400">
                            Dengan bahan berkualitas premium dan teknologi sablon terbaik, kami siap mewujudkan setiap
                            desain impian Anda menjadi kenyataan, baik untuk pesanan satuan maupun dalam jumlah besar.
                            Bergabunglah bersama kami dan tunjukkan gayamu yang sesungguhnya.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Seksi Keunggulan Kami --}}
        <section id="keunggulan" class="py-20 sm:py-24 bg-gray-900">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white">Kenapa Memilih Kami?</h2>
                    <p class="mt-2 text-gray-400">Kualitas dan kepuasanmu adalah prioritas utama kami.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="reveal-card text-center p-8 bg-black rounded-2xl">
                        <div class="inline-block p-4 bg-gray-800 rounded-full">
                            <i data-lucide="gem" class="h-8 w-8 text-yellow-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mt-4">Bahan Premium</h3>
                        <p class="text-gray-400 mt-2">Kami hanya menggunakan material terbaik seperti Cotton Fleece
                            280gsm yang nyaman dan tahan lama.</p>
                    </div>
                    <div class="reveal-card text-center p-8 bg-black rounded-2xl">
                        <div class="inline-block p-4 bg-gray-800 rounded-full">
                            <i data-lucide="layers" class="h-8 w-8 text-yellow-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mt-4">Teknologi Sablon Modern</h3>
                        <p class="text-gray-400 mt-2">Dari DTF hingga Plastisol, kami gunakan teknologi yang tepat untuk
                            hasil detail dan warna yang maksimal.</p>
                    </div>
                    <div class="reveal-card text-center p-8 bg-black rounded-2xl">
                        <div class="inline-block p-4 bg-gray-800 rounded-full">
                            <i data-lucide="sparkles" class="h-8 w-8 text-yellow-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mt-4">Tanpa Minimum Order</h3>
                        <p class="text-gray-400 mt-2">Pesan satuan untuk koleksi pribadi atau lusinan untuk komunitasmu.
                            Kami siap melayani.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Koleksi --}}
        <section id="koleksi" class="py-20 sm:py-24">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white">KOLEKSI KAMI</h2>
                    <p class="text-gray-400 mt-2">Temukan produk yang sesuai dengan gayamu.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($products as $product)
                        <div
                            class="reveal-card bg-gray-900 rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300 group">
                            <div class="relative overflow-hidden h-72">
                                <img src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-white mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-400 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-lg font-bold text-yellow-500">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('product.detail', $product->id) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-black bg-yellow-500 rounded-lg hover:bg-white transition">
                                        Lihat Detail
                                        <i data-lucide="arrow-right" class="h-4 w-4 ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Seksi FAQ --}}
        <section id="faq" class="py-20 sm:py-24 bg-gray-900">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white">Tanya Jawab</h2>
                    <p class="mt-2 text-gray-400">Temukan jawaban dari pertanyaan yang sering diajukan.</p>
                </div>
                <div class="max-w-3xl mx-auto space-y-4" x-data="{ open: 1 }">
                    <div class="reveal-card bg-black rounded-lg">
                        <button @click="open = (open === 1 ? 0 : 1)" class="w-full text-left p-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-white">Apakah bisa memesan satuan?</span>
                                <i data-lucide="chevron-down" class="transition-transform"
                                    :class="{'rotate-180': open === 1}"></i>
                            </div>
                        </button>
                        <div x-show="open === 1" x-collapse class="px-4 pb-4 text-gray-400">
                            <p>Tentu saja! Kami melayani pemesanan satuan tanpa minimum order. Sangat cocok untuk kamu
                                yang ingin punya apparel eksklusif atau sebagai hadiah.</p>
                        </div>
                    </div>
                    <div class="reveal-card bg-black rounded-lg">
                        <button @click="open = (open === 2 ? 0 : 2)" class="w-full text-left p-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-white">Berapa lama proses pengerjaannya?</span>
                                <i data-lucide="chevron-down" class="transition-transform"
                                    :class="{'rotate-180': open === 2}"></i>
                            </div>
                        </button>
                        <div x-show="open === 2" x-collapse class="px-4 pb-4 text-gray-400">
                            <p>Proses pengerjaan normalnya memakan waktu 3-7 hari kerja, tergantung pada kerumitan
                                desain dan antrian produksi. Kami akan selalu memberikan estimasi waktu saat konfirmasi
                                pesanan.</p>
                        </div>
                    </div>
                    <div class="reveal-card bg-black rounded-lg">
                        <button @click="open = (open === 3 ? 0 : 3)" class="w-full text-left p-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-white">Jenis sablon apa yang digunakan?</span>
                                <i data-lucide="chevron-down" class="transition-transform"
                                    :class="{'rotate-180': open === 3}"></i>
                            </div>
                        </button>
                        <div x-show="open === 3" x-collapse class="px-4 pb-4 text-gray-400">
                            <p>Untuk pesanan satuan atau di bawah selusin, kami menggunakan sablon DTF (Direct to Film)
                                yang menghasilkan warna cerah dan detail tajam. Untuk pesanan minimal 12 pcs dengan
                                desain yang sama, kami menggunakan sablon Plastisol yang terkenal awet dan berkualitas
                                tinggi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="bg-black py-12">
        <div class="container mx-auto px-6 text-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left mb-8">
                <div>
                    <h3 class="font-bold text-white text-lg mb-3">KESTORE.ID</h3>
                    <p class="text-sm">Spesialis custom apparel untuk gaya unikmu. Kualitas premium, desain tanpa
                        batas.</p>
                </div>

                <div>
                    <h3 class="font-bold text-white text-lg mb-3">Lokasi Kami</h3>
                    <p class="text-sm">
                        Komplek Margaasih Permai, Jl. Sedap Malam No.22 blok U1, RT.04/RW.19, Margaasih, Kabupaten
                        Bandung, Jawa Barat 40215
                    </p>
                    <a href="https://www.google.com/maps/search/?api=1&query=KESTOREID,Komplek+Margaasih+Permai"
                        target="_blank"
                        class="inline-flex items-center text-sm text-yellow-500 hover:text-white mt-2 transition">
                        Lihat di Google Maps
                        <i data-lucide="map-pin" class="h-4 w-4 ml-2"></i>
                    </a>
                </div>

                <div>
                    <h3 class="font-bold text-white text-lg mb-3">Temukan Kami Di</h3>
                    <div class="flex justify-center md:justify-start space-x-4 mt-2">
                        <a href="#" target="_blank" class="text-gray-400 hover:text-white transition" title="Instagram">
                            <i data-lucide="instagram" class="h-6 w-6"></i>
                        </a>
                        <a href="#" target="_blank" class="text-gray-400 hover:text-white transition" title="TikTok">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-2.43.03-4.83-.95-6.46-2.9-1.6-1.92-2.3-4.43-1.8-6.83.47-2.31 1.98-4.25 3.98-5.46 2.02-1.2 4.54-1.42 6.74-1.02.01 2.38-.01 4.75.02 7.12-.52-.15-1.03-.3-1.52-.47-1.42-.48-2.9-.8-4.27-1.15.28-2.26.88-4.4 2.15-6.19C10.22 2.12 11.33.91 12.525.02z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" target="_blank" class="text-gray-400 hover:text-white transition" title="Shopee">
                            <i data-lucide="shopping-cart" class="h-6 w-6"></i>
                        </a>
                        <a href="#" target="_blank" class="text-gray-400 hover:text-white transition" title="Tokopedia">
                            <i data-lucide="shopping-bag" class="h-6 w-6"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-sm">© {{ date('Y') }} Kestore.id. All Rights Reserved.</p>
            </div>
        </div>
    </footer>


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
