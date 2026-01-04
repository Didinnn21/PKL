<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kestore.id - Custom Apparel Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; color: #e2e8f0; scroll-behavior: smooth; }
        .force-black { color: #000000 !important; }
        .reveal-card { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .reveal-card.visible { opacity: 1; transform: translateY(0); }
        .btn-premium { background: linear-gradient(135deg, #d4af37 0%, #f2d06b 50%, #b38f24 100%); color: #000000 !important; @apply inline-flex items-center justify-center px-7 py-3 text-sm font-black uppercase tracking-widest rounded-full transition-all duration-500 transform hover:-translate-y-1; }
        .glass-card { background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); @apply rounded-[2rem] transition-all duration-500; }
        .step-number { @apply w-12 h-12 rounded-full border-2 border-[#d4af37] text-[#d4af37] flex items-center justify-center font-black text-xl mb-4; }
    </style>
</head>

<body class="antialiased selection:bg-[#d4af37] selection:text-black">

    {{-- HEADER/NAVBAR --}}
    <header x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="{ 'bg-black/95 border-b border-white/10': scrolled, 'bg-transparent': !scrolled }"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
        <div class="container mx-auto px-6 h-24 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/kestore-logo.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="text-xl lg:text-2xl font-black text-white uppercase tracking-tighter">KESTORE<span class="text-[#d4af37]">.ID</span></span>
            </a>
            <nav class="hidden lg:flex items-center space-x-12 text-sm font-semibold text-gray-400">
                <a href="#koleksi" class="hover:text-[#d4af37]">KOLEKSI</a>
                <a href="#cara-order" class="hover:text-[#d4af37]">CARA ORDER</a>
                <a href="#custom-order" class="hover:text-[#d4af37]">PESAN CUSTOM</a>
                <a href="#tentang-kami" class="hover:text-[#d4af37]">TENTANG KAMI</a>
            </nav>
            <div class="flex items-center gap-6 text-sm font-bold">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-premium force-black">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-[#d4af37] transition-colors">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn-premium force-black">DAFTAR</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        {{-- HERO SECTION --}}
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden text-center px-6">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/BG.jpg') }}" class="w-full h-full object-cover opacity-40 scale-110">
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-[#050505]/95 to-[#050505]"></div>
            </div>
            <div class="relative z-10 reveal-card">
                <div class="text-[#d4af37] text-[10px] font-black tracking-[0.4em] uppercase mb-6">Premium Custom Apparel Est. 2021</div>
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white mb-10 tracking-tighter uppercase leading-none">Master your <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] via-[#f2d06b] to-[#b38f24]">Creativity</span></h1>
                <p class="text-lg md:text-2xl text-gray-400 mb-16 max-w-3xl mx-auto italic font-medium">Wujudkan desain impianmu dengan kualitas kain distro premium tanpa batas minimum order.</p>
                <a href="#custom-order" class="btn-premium force-black min-w-[260px] py-5">MULAI DESAIN SEKARANG</a>
            </div>
        </section>

        {{-- TENTANG KAMI --}}
        <section id="tentang-kami" class="py-32 bg-[#050505]">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="reveal-card">
                        <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none mb-8">Standardisasi Baru <br> <span class="text-[#d4af37]">Fashion Kustom</span></h2>
                        <div class="space-y-6 text-gray-400 text-lg leading-relaxed">
                            <p>Kestore.id adalah brand lokal spesialis apparel kustom yang lahir sejak 2021 untuk menjawab tantangan dunia fashion personal yang seringkali terkendala batas minimum order.</p>
                            <p>Kami menggabungkan material kain premium standar distro dengan teknologi sablon modern DTF untuk memastikan setiap detail imajinasi Anda tercetak sempurna.</p>
                        </div>
                        <div class="mt-12 flex flex-wrap gap-8">
                            <div class="border-l-2 border-[#d4af37] pl-6">
                                <h4 class="text-white font-black text-3xl">2021</h4>
                                <p class="text-gray-500 text-sm uppercase font-bold">Hadir Sejak</p>
                            </div>
                            <div class="border-l-2 border-[#d4af37] pl-6">
                                <h4 class="text-white font-black text-3xl">PREMIUM</h4>
                                <p class="text-gray-500 text-sm uppercase font-bold">Kualitas Distro</p>
                            </div>
                        </div>
                    </div>
                    <div class="reveal-card">
                        <div class="glass-card p-4">
                            <img src="{{ asset('images/Brand-Story.jpg') }}" alt="Brand Story" class="rounded-[1.5rem] w-full shadow-2xl filter contrast-125 grayscale hover:grayscale-0 transition-all duration-700">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- KATALOG PRODUK --}}
        <section id="koleksi" class="py-32 bg-[#080808]">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="text-center mb-20 reveal-card">
                    <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter italic">Katalog Pilihan</h2>
                    <div class="h-1.5 w-24 bg-[#d4af37] mx-auto rounded-full mt-4 shadow-[0_0_15px_rgba(212,175,55,0.5)]"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="reveal-card glass-card overflow-hidden group">
                        <div class="relative h-[450px] overflow-hidden">
                            <img src="{{ asset('images/P-Hoodie.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-6 right-6 bg-[#d4af37] force-black font-black px-4 py-2 rounded-full text-[10px] shadow-xl">MULAI Rp 465rb</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-white mb-2 uppercase tracking-tighter">Hoodie Premium</h3>
                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Cotton Fleece 280gsm kualitas ekspor terbaik.</p>
                        </div>
                    </div>
                    <div class="reveal-card glass-card overflow-hidden group">
                        <div class="relative h-[450px] overflow-hidden">
                            <img src="{{ asset('images/Slide-2.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-6 right-6 bg-[#d4af37] force-black font-black px-4 py-2 rounded-full text-[10px] shadow-xl">MULAI Rp 115rb</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-white mb-2 uppercase tracking-tighter">T-Shirt Kustom</h3>
                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Cotton Combed 30s sejuk dan nyaman dipakai.</p>
                        </div>
                    </div>
                    <div class="reveal-card glass-card overflow-hidden group">
                        <div class="relative h-[450px] overflow-hidden">
                            <img src="{{ asset('images/HOODIE.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-6 right-6 bg-[#d4af37] force-black font-black px-4 py-2 rounded-full text-[10px] shadow-xl">Rp 185.000</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-white mb-2 uppercase tracking-tighter">Crewneck Classic</h3>
                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Material premium dengan jahitan rapi standar distro.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- LANGKAH PEMESANAN --}}
        <section id="cara-order" class="py-32 bg-[#050505]">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="text-center mb-20 reveal-card">
                    <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter leading-tight">Langkah Pemesanan</h2>
                    <p class="text-gray-500 font-medium italic mt-2 text-sm uppercase tracking-widest">Proses mudah & transparan</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="reveal-card glass-card p-10 border-t-4 border-[#d4af37] text-left">
                        <div class="step-number">1</div>
                        <h4 class="text-white font-black mb-4 uppercase tracking-tight">Daftar Akun</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Wajib registrasi untuk fitur custom order dan riwayat transaksi.</p>
                    </div>
                    <div class="reveal-card glass-card p-10 border-t-4 border-[#d4af37] text-left">
                        <div class="step-number">2</div>
                        <h4 class="text-white font-black mb-4 uppercase tracking-tight">Kirim Desain</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Gunakan menu "Pesan Custom" dan unggah file desain terbaik Anda.</p>
                    </div>
                    <div class="reveal-card glass-card p-10 border-t-4 border-[#d4af37] text-left">
                        <div class="step-number">3</div>
                        <h4 class="text-white font-black mb-4 uppercase tracking-tight">Pembayaran</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Lakukan transfer bank sesuai tagihan dan unggah bukti transfer.</p>
                    </div>
                    <div class="reveal-card glass-card p-10 border-t-4 border-[#d4af37] text-left">
                        <div class="step-number">4</div>
                        <h4 class="text-white font-black mb-4 uppercase tracking-tight">Produksi</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Pesanan Anda diproses admin hingga dipacking dan dikirim.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- PESAN PRODUK CUSTOM (FORM) --}}
        <section id="custom-order" class="py-40 bg-[#080808]">
            <div class="container mx-auto px-6">
                <div class="max-w-5xl mx-auto">
                    <div class="text-center mb-24 reveal-card uppercase">
                        <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter italic">Buat Desainmu</h2>
                        <div class="h-2 w-32 bg-[#d4af37] mx-auto rounded-full mt-4"></div>
                    </div>

                    @auth
                        <div class="glass-card p-10 md:p-16 reveal-card border-l-8 border-l-[#d4af37]">
                            <form action="{{ route('member.custom.order') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-left">
                                    <div class="space-y-4">
                                        <label class="text-xs font-black text-gray-500 uppercase tracking-widest ml-2">Nama Projek</label>
                                        <input type="text" name="name" class="w-full px-6 py-4 text-white bg-black border border-white/10 rounded-2xl focus:border-[#d4af37] outline-none" placeholder="Contoh: Kaos Komunitas" required>
                                    </div>
                                    <div class="space-y-4">
                                        <label class="text-xs font-black text-gray-500 uppercase tracking-widest ml-2">Jumlah (Pcs)</label>
                                        <input type="number" name="quantity" class="w-full px-6 py-4 text-white bg-black border border-white/10 rounded-2xl focus:border-[#d4af37] outline-none" placeholder="1" required>
                                    </div>
                                </div>
                                <div class="space-y-4 text-left">
                                    <label class="text-xs font-black text-gray-500 uppercase tracking-widest ml-2">File Desain (JPG/PNG)</label>
                                    <input type="file" name="image" class="w-full px-6 py-10 text-gray-500 bg-black border border-white/10 rounded-2xl border-dashed hover:border-[#d4af37] transition-all">
                                </div>
                                <div class="space-y-4 text-left">
                                    <label class="text-xs font-black text-gray-500 uppercase tracking-widest ml-2">Detail Instruksi</label>
                                    <textarea name="description" rows="5" class="w-full px-6 py-4 text-white bg-black border border-white/10 rounded-2xl focus:border-[#d4af37] outline-none" placeholder="Detail sablon, warna kain, dll..."></textarea>
                                </div>
                                <button type="submit" class="btn-premium force-black w-full text-lg py-6 shadow-2xl">KIRIM PESANAN SEKARANG</button>
                            </form>
                        </div>
                    @else
                        {{-- AKSES EKSKLUSIF MEMBER --}}
                        <div class="glass-card p-24 text-center reveal-card border-dashed border-2 border-[#d4af37]/30">
                            <i data-lucide="lock" class="w-20 h-20 mx-auto mb-10 text-[#d4af37]/40"></i>
                            <h3 class="text-4xl font-black text-white mb-8 uppercase tracking-tighter">Akses Eksklusif Member</h3>
                            <p class="text-xl text-gray-400 mb-14 max-w-lg mx-auto font-medium">Silakan masuk ke akun Anda atau daftar untuk memulai pemesanan kustom premium.</p>
                            <div class="flex flex-col sm:flex-row justify-center gap-8">
                                <a href="{{ route('login') }}" class="px-10 py-4 border border-white/20 rounded-full font-black text-xs uppercase tracking-widest hover:bg-white hover:text-black transition-all">Login</a>
                                <a href="{{ route('register') }}" class="btn-premium force-black px-10 py-4 shadow-xl shadow-[#d4af37]/20">Daftar Sekarang</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-black py-24 border-t border-white/10 relative z-10">
        <div class="container mx-auto px-6 lg:px-12 text-center md:text-left">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-24">
                <div class="col-span-1 md:col-span-2 space-y-8">
                    <div class="flex items-center gap-4 justify-center md:justify-start">
                        <img src="{{ asset('images/kestore-logo.png') }}" class="h-12 shadow-lg">
                        <span class="text-3xl font-black text-white tracking-tighter uppercase leading-none block">KESTORE<span class="text-[#d4af37]">.ID</span></span>
                    </div>
                    <p class="text-gray-500 max-w-md leading-relaxed text-lg font-medium mx-auto md:mx-0 italic">Standardisasi baru dalam fashion kustom premium sejak 2021.</p>
                </div>
                <div>
                    <h4 class="text-white font-black mb-10 uppercase tracking-[0.2em] text-xs">Navigasi</h4>
                    <ul class="space-y-6 text-gray-500 font-bold text-sm">
                        <li><a href="#koleksi" class="hover:text-[#d4af37] transition-all">KATALOG PRODUK</a></li>
                        <li><a href="#cara-order" class="hover:text-[#d4af37] transition-all">CARA ORDER</a></li>
                        <li><a href="#tentang-kami" class="hover:text-[#d4af37] transition-all">TENTANG KESTORE</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-black mb-10 uppercase tracking-[0.2em] text-xs">Media Sosial</h4>
                    <ul class="space-y-6 text-gray-500 font-bold text-sm mb-10">
                        <li class="flex items-center gap-4 group justify-center md:justify-start">
                            <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center group-hover:bg-[#d4af37] transition-all duration-500"><i data-lucide="instagram" class="w-5 h-5 text-[#d4af37] group-hover:text-black"></i></div>
                            <a href="https://instagram.com/kestore.id" target="_blank" class="group-hover:text-white uppercase transition-colors">Instagram</a>
                        </li>
                        <li class="flex items-center gap-4 group justify-center md:justify-start">
                            <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center group-hover:bg-[#d4af37] transition-all duration-500">
                                <svg class="w-5 h-5 text-[#d4af37] group-hover:text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-2.43.03-4.83-.95-6.46-2.9-1.6-1.92-2.3-4.43-1.8-6.83.47-2.31 1.98-4.25 3.98-5.46 2.02-1.2 4.54-1.42 6.74-1.02.01 2.38-.01 4.75.02 7.12-.52-.15-1.03-.3-1.52-.47-1.42-.48-2.9-.8-4.27-1.15.28-2.26.88-4.4 2.15-6.19C10.22 2.12 11.33.91 12.525.02z"></path></svg>
                            </div>
                            <a href="https://tiktok.com/@kestore.id" target="_blank" class="group-hover:text-white uppercase transition-colors">TikTok</a>
                        </li>
                    </ul>
                    <a href="mailto:cs@kestore.id" class="text-[#d4af37] font-black text-sm hover:underline uppercase tracking-widest">CS@KESTORE.ID</a>
                </div>
            </div>
            <div class="pt-12 border-t border-white/5 text-center">
                <p class="text-[10px] font-black text-gray-600 tracking-[0.5em] uppercase">© 2026 Kestore.id • Premium Apparel Division. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal-card').forEach(card => observer.observe(card));
    </script>
</body>
</html>
