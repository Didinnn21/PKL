@extends('layouts.dashboard')

@section('title', 'Detail Pesanan #KESTORE-' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
            <h1 class="h2">Detail Pesanan</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <strong>ID Pesanan: #KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Detail Produk</h5>
                        <p><strong>Nama Produk:</strong> {{ $order->product->name ?? 'Produk Dihapus' }}</p>
                        <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
                        <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <hr>
                        <h5 class="card-title">Alamat Pengiriman</h5>
                        <p>{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Informasi Pembeli</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                        <p><strong>Status Pesanan:</strong> <span class="badge"
                                style="background-color:#ffc107; color:#1a1a1a;">{{ $order->status }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
