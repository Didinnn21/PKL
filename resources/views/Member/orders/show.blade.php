@extends('layouts.member')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold text-white mb-0">Detail Pesanan #{{ $order->id }}</h2>
            <a href="{{ route('member.orders.index') }}" class="btn btn-outline-light btn-sm">Kembali</a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-lg border-secondary mb-4" style="background-color: #141414;">
                    <div class="card-body p-4">
                        <h5 class="text-white border-bottom border-secondary pb-3 mb-3">Item Pesanan</h5>
                        <div class="d-flex mb-3">
                            {{-- Jika produk custom (product_id null), tampilkan desain --}}
                            @if($order->product)
                                <img src="{{ asset('images/product/' . $order->product->image) }}" class="rounded me-3"
                                    width="80" height="80" style="object-fit: cover;">
                                <div>
                                    <h6 class="text-white mb-1">{{ $order->product->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $order->quantity }} x Rp
                                        {{ number_format($order->product->price, 0, ',', '.') }}</p>
                                </div>
                            @else
                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-tshirt text-white"></i>
                                </div>
                                <div>
                                    <h6 class="text-white mb-1">Custom Order</h6>
                                    <p class="text-muted small mb-0">{{ $order->notes }}</p>
                                    <p class="text-warning small fw-bold">Qty: {{ $order->quantity }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-lg border-secondary" style="background-color: #141414;">
                    <div class="card-body p-4">
                        <h5 class="text-white border-bottom border-secondary pb-3 mb-3">Ringkasan</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-white fw-bold">Total Bayar</span>
                            <span class="text-warning fw-bold fs-5">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        @if($order->status == 'Menunggu Pembayaran')
                            <div class="d-grid">
                                <a href="{{ route('member.orders.payment', $order->id) }}"
                                    class="btn btn-warning fw-bold text-dark py-2">
                                    <i class="fas fa-money-bill-wave me-2"></i> Bayar Sekarang
                                </a>
                            </div>
                        @elseif($order->status == 'Menunggu Verifikasi')
                            <div class="alert alert-info bg-opacity-10 border-info text-info small">
                                <i class="fas fa-clock me-1"></i> Bukti bayar sedang diverifikasi Admin.
                            </div>
                        @elseif($order->status == 'Menunggu Konfirmasi')
                            <div class="alert alert-warning bg-opacity-10 border-warning text-warning small">
                                <i class="fas fa-hourglass-half me-1"></i> Menunggu Admin mengkonfirmasi harga.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection