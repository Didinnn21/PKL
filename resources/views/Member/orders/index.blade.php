@extends('layouts.member')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold text-white mb-0">Riwayat Pesanan</h2>
            <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold text-dark btn-sm">
                <i class="fas fa-plus me-2"></i> Pesan Lagi
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-25 text-white border-0 mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-secondary" style="background-color: #141414;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="color: #fff; border-color: #333;">
                                <thead class="bg-black text-warning">
                                    <tr>
                                        <th class="py-3 ps-4">ID Order</th>
                                        <th class="py-3">Produk</th>
                                        <th class="py-3">Total Harga</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3 text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr style="border-bottom: 1px solid #333;">
                                            <td class="ps-4 fw-bold text-muted">#{{ $order->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($order->product)
                                                        <img src="{{ asset('images/product/' . $order->product->image) }}"
                                                            class="rounded border border-secondary me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                            onerror="this.src='{{ asset('images/kestore-logo.png') }}'">
                                                        <div>
                                                            <span
                                                                class="d-block fw-bold text-white">{{ $order->product->name }}</span>
                                                            <small class="text-muted">{{ $order->quantity }} pcs</small>
                                                        </div>
                                                    @else
                                                        <div class="rounded border border-secondary me-3 d-flex align-items-center justify-content-center bg-dark"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="fas fa-tshirt text-warning"></i>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-bold text-white">Custom Order</span>
                                                            <small class="text-muted">{{ $order->quantity }} pcs</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-warning fw-bold">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @if($order->status == 'Menunggu Pembayaran')
                                                    <span class="badge bg-warning text-dark">Belum Dibayar</span>
                                                @elseif($order->status == 'Menunggu Verifikasi')
                                                    <span class="badge bg-info text-dark">Sedang Diverifikasi</span>
                                                @elseif($order->status == 'Menunggu Konfirmasi')
                                                    <span class="badge bg-secondary text-white">Menunggu Harga</span>
                                                @else
                                                    <span class="badge bg-success text-white">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                {{-- TOMBOL AKSI --}}
                                                <div class="btn-group">
                                                    {{-- Jika Status Menunggu Pembayaran, Tampilkan Tombol Bayar --}}
                                                    @if($order->status == 'Menunggu Pembayaran')
                                                        <a href="{{ route('member.orders.payment', $order->id) }}"
                                                            class="btn btn-warning btn-sm text-dark fw-bold me-2">
                                                            <i class="fas fa-upload me-1"></i> Bayar
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('member.orders.show', $order->id) }}"
                                                        class="btn btn-outline-light btn-sm">
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <p class="mb-0">Anda belum memiliki riwayat pesanan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($orders->hasPages())
                        <div class="card-footer border-top border-secondary py-3" style="background-color: #141414;">
                            <div class="d-flex justify-content-center">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
