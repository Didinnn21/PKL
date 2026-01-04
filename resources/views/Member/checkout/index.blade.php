@extends('layouts.member')

@section('title', 'Selesaikan Pembayaran')

@push('styles')
    <style>
        body { background-color: #050505; color: #e2e8f0; font-family: 'Plus Jakarta Sans', sans-serif; }
        .force-black { color: #000000 !important; }
        .glass-card { background: rgba(15, 15, 15, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; }
        .border-gold { border: 1px solid #d4af37 !important; }
        .text-gold { color: #d4af37 !important; }

        .input-premium {
            width: 100%; padding: 1rem; background-color: #000000 !important;
            border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
            color: #ffffff; outline: none; transition: all 0.3s;
        }
        .input-premium:focus { border-color: #d4af37; box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2); }

        .btn-premium {
            background: linear-gradient(135deg, #d4af37 0%, #f2d06b 50%, #b38f24 100%);
            color: #000000 !important; font-weight: 900; text-transform: uppercase;
            letter-spacing: 2px; border-radius: 12px; border: none; padding: 1.2rem;
            width: 100%; transition: all 0.3s; cursor: pointer;
        }
        .btn-premium:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4); }
    </style>
@endpush

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="text-center mb-5">
        <div class="d-inline-block px-4 py-2 bg-black border border-white/10 rounded-full text-[10px] font-black tracking-[3px] uppercase mb-3 text-white">Proses Checkout Aman</div>
        <h2 class="fw-black text-white uppercase tracking-tighter italic" style="font-size: 2.5rem;">Selesaikan <span class="text-gold">Pesanan</span></h2>
    </div>

    {{-- 1. CSRF Ditambahkan untuk mencegah error 419 --}}
    <form action="{{ route('member.checkout.process') }}" method="POST">
        @csrf
        <div class="row g-4">

            <div class="col-lg-8">

                <div class="glass-card p-4 mb-4 border-gold">
                    <h5 class="text-white fw-bold mb-4 uppercase tracking-wider small">1. Produk Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-secondary small uppercase border-bottom border-white/10">
                                    <th class="pb-3">Nama Produk</th>
                                    <th class="pb-3 text-center">Jumlah</th>
                                    <th class="pb-3 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td class="py-4">
                                        <div class="d-flex align-items-center gap-3">
                                            {{-- 2. Jalur Gambar diperbaiki sesuai struktur storage/products Anda --}}
                                            <img src="{{ asset('storage/products/' . ($item->product->image ?? 'default.jpg')) }}"
                                                 class="rounded-3 border border-white/10 shadow" width="70" height="70" style="object-fit: cover;"
                                                 onerror="this.src='{{ asset('images/Slide-2.png') }}'">
                                            <div>
                                                <div class="text-white fw-bold uppercase" style="font-size: 14px;">{{ $item->product->name }}</div>
                                                <div class="text-gold small fw-black">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-gray-400">{{ $item->quantity }}</td>
                                    <td class="text-end fw-black text-white">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="glass-card p-4 border-gold">
                    <h5 class="text-white fw-bold mb-4 uppercase tracking-wider small">2. Informasi Pengiriman</h5>
                    <div class="mb-4 text-start">
                        <label class="text-secondary small fw-black uppercase tracking-widest mb-2 d-block">Alamat Lengkap Tujuan</label>
                        <textarea name="shipping_address" class="input-premium" rows="3" required placeholder="Contoh: Jl. Soekarno Hatta No.456, Bandung...">{{ auth()->user()->address }}</textarea>
                    </div>
                    <div class="text-start">
                        <label class="text-secondary small fw-black uppercase tracking-widest mb-2 d-block">Pilih Kurir Pengiriman</label>
                        <select name="shipping_service" id="shipping_service" class="input-premium" required>
                            <option value="" data-price="0">-- Pilih Layanan Kurir --</option>
                            @foreach($shippingOptions as $ship)
                                <option value="{{ $ship->id }}" data-price="{{ $ship->price }}">
                                    {{ strtoupper($ship->name) }} (Rp {{ number_format($ship->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="glass-card p-4 sticky-top" style="top: 20px;">
                    <h5 class="text-white fw-bold mb-4 border-bottom border-white/10 pb-3">Ringkasan Biaya</h5>
                    <div class="d-flex justify-content-between mb-3 text-sm">
                        <span class="text-secondary uppercase font-bold small">Harga Produk</span>
                        <span class="text-white fw-black">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 text-sm">
                        <span class="text-secondary uppercase font-bold small">Biaya Kirim</span>
                        <span class="text-gold fw-black" id="cost_display">Rp 0</span>
                    </div>
                    <div class="border-top border-white/10 pt-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-white fw-black uppercase tracking-tighter">Total Bayar</span>
                            <h3 class="text-gold fw-black mb-0 tracking-tighter" id="grand_total">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <button type="submit" class="btn-premium force-black">Buat Pesanan Sekarang</button>
                    <div class="mt-4 p-3 rounded-3 bg-black text-center border border-white/5">
                        <p class="text-secondary mb-0 fw-bold uppercase tracking-widest" style="font-size: 8px;">
                            Pembayaran Aman & Terverifikasi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingSelect = document.getElementById('shipping_service');
        const costDisplay = document.getElementById('cost_display');
        const grandTotalDisplay = document.getElementById('grand_total');
        const productTotal = {{ $total }};

        shippingSelect.addEventListener('change', function() {
            const cost = parseInt(this.options[this.selectedIndex].dataset.price) || 0;
            const total = productTotal + cost;
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
            costDisplay.innerText = formatter.format(cost);
            grandTotalDisplay.innerText = formatter.format(total);
        });
    });
</script>
@endpush
