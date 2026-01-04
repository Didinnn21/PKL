@extends('layouts.member')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid pt-4">
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-white mb-1">
                <i class="fas fa-file-invoice text-warning me-2"></i> Detail Pesanan
            </h4>
            <p class="text-white-50 small mb-0">
                ID Transaksi: #{{ $order->id }} | Dibuat pada: {{ $order->created_at->format('d M Y, H:i') }}
            </p>
        </div>
        <a href="{{ route('member.orders.index') }}" class="btn btn-warning btn-sm fw-bold text-dark px-3 shadow-sm">
            <i class="fas fa-chevron-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: DAFTAR PRODUK & PENGIRIMAN --}}
        <div class="col-lg-8">
            {{-- KARTU DAFTAR PRODUK --}}
            <div class="card shadow-lg border-secondary mb-4" style="background-color: #141414; border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="text-white border-bottom border-secondary pb-3 mb-4">
                        <i class="fas fa-shopping-bag text-warning me-2"></i> Daftar Produk
                    </h5>

                    @if($order->items && $order->items->count() > 0)
                        @foreach($order->items as $item)
                            <div class="d-flex align-items-center mb-4 pb-4 border-bottom border-secondary last-border-none">
                                <img src="{{ asset($item->product->image_url ?? 'https://placehold.co/80x80/1a1a1a/d4af37?text=P') }}"
                                     class="rounded border border-secondary me-3"
                                     width="80" height="80" style="object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="text-white mb-1 fw-bold">{{ $item->product->name }}</h6>
                                    <p class="text-white-50 small mb-1">
                                        Ukuran: <span class="text-warning fw-bold">{{ $item->size ?? 'Standar' }}</span>
                                    </p>
                                    <p class="text-white-50 small mb-0">
                                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p class="text-warning fw-bold mb-0">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- TAMPILAN UNTUK PESANAN CUSTOM --}}
                        <div class="d-flex align-items-center">
                            <div class="bg-dark border border-secondary rounded me-3 d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-tshirt text-warning fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1 fw-bold">Pesanan Kustom (Legacy)</h6>
                                <p class="text-white-50 small mb-1">{{ $order->notes ?? 'Tidak ada catatan khusus' }}</p>
                                <p class="text-warning small fw-bold mb-0">Jumlah: {{ $order->quantity }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- KARTU INFORMASI PENGIRIMAN --}}
            <div class="card shadow-lg border-secondary" style="background-color: #141414; border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="text-white border-bottom border-secondary pb-3 mb-4">
                        <i class="fas fa-truck text-warning me-2"></i> Informasi Pengiriman
                    </h5>
                    <div class="row text-white">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-white-50 small d-block mb-1 text-uppercase fw-bold">Kurir & Layanan</label>
                            <p class="fw-bold mb-0 text-warning">{{ strtoupper($order->shipping_service ?? 'Standar') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-white-50 small d-block mb-1 text-uppercase fw-bold">Alamat Lengkap</label>
                            <p class="mb-0 small leading-relaxed">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RINGKASAN PEMBAYARAN --}}
        <div class="col-lg-4">
            <div class="card shadow-lg border-secondary sticky-top" style="background-color: #141414; border-radius: 12px; top: 20px;">
                <div class="card-body p-4 text-white">
                    <h5 class="text-white border-bottom border-secondary pb-3 mb-4">Ringkasan Pembayaran</h5>

                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-white-50">Status Pesanan</span>
                        @php
                            $statusMap = [
                                'pending' => ['label' => 'BELUM DIBAYAR', 'class' => 'bg-danger'],
                                'Menunggu Pembayaran' => ['label' => 'BELUM DIBAYAR', 'class' => 'bg-danger'],
                                'MENUNGGU VERIFIKASI' => ['label' => 'VERIFIKASI', 'class' => 'bg-info text-dark'],
                                'VERIFIKASI' => ['label' => 'VERIFIKASI', 'class' => 'bg-info text-dark'],
                                'SELESAI' => ['label' => 'SELESAI', 'class' => 'bg-success'],
                                'DIPROSES' => ['label' => 'DIPROSES', 'class' => 'bg-primary']
                            ];
                            $currentStatus = $statusMap[$order->status] ?? ['label' => strtoupper($order->status), 'class' => 'bg-secondary'];
                        @endphp
                        <span class="badge {{ $currentStatus['class'] }} px-3 py-2 text-uppercase fw-bold">
                            {{ $currentStatus['label'] }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white-50">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($order->total_price - ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-white-50">Ongkos Kirim</span>
                        <span class="fw-bold">Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between border-top border-secondary pt-3 mb-4">
                        <span class="fw-bold text-white fs-5">Total Bayar</span>
                        <span class="text-warning fw-bold fs-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>

                    {{-- STATUS VERIFIKASI --}}
                    @if($order->status == 'MENUNGGU VERIFIKASI' || $order->status == 'VERIFIKASI')
                        <div class="alert alert-info border-info bg-dark text-info small mb-0 d-flex align-items-center shadow-sm">
                            <i class="fas fa-clock me-2 fs-5"></i>
                            <span>Bukti bayar sedang diverifikasi oleh tim Kestore.id.</span>
                        </div>
                    @elseif($order->status == 'pending' || $order->status == 'Menunggu Pembayaran')
                        <div class="d-grid">
                            <a href="{{ route('member.orders.payment', $order->id) }}" class="btn btn-warning fw-bold text-dark py-3">
                                <i class="fas fa-money-bill-wave me-2"></i> BAYAR SEKARANG
                            </a>
                        </div>
                    @endif

                    {{-- TAMPILAN BUKTI TRANSFER --}}
                    @if($order->payment_proof)
                        <div class="mt-4 pt-4 border-top border-secondary">
                            <label class="text-white-50 small d-block mb-2 text-uppercase fw-bold">Bukti Pembayaran</label>
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                     class="img-fluid rounded border border-secondary"
                                     style="max-height: 150px; width: 100%; object-fit: cover;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .last-border-none:last-child { border-bottom: none !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
    .leading-relaxed { line-height: 1.6; }
</style>
@endsection
