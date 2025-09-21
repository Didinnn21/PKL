@extends('layouts.member')
@section('title', 'Detail Pesanan #KESTORE-' . str_pad($order->id, 4, '0', STR_PAD_LEFT))
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
            <h1 class="h2">Detail Pesanan</h1>
            <a href="{{ route('member.orders.index') }}" class="btn btn-outline-secondary"><i
                    class="fas fa-arrow-left me-1"></i> Kembali</a>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card" style="background-color:#2c2c2c; border-color:#444;">
                    <div class="card-header" style="background-color:#333;"><strong>ID:
                            #KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
                    <div class="card-body">
                        <h5 class="card-title">Detail Produk Dipesan</h5>
                        <p><strong>Nama Produk:</strong> {{ $order->product->name ?? 'Produk Dihapus' }}</p>
                        <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
                        <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <hr style="border-color:#555;">
                        <h5 class="card-title">Alamat Pengiriman</h5>
                        <p>{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="background-color:#2c2c2c; border-color:#444;">
                    <div class="card-header" style="background-color:#333;"><strong>Status Pesanan</strong></div>
                    <div class="card-body text-center">
                        <h3 class="mb-3" style="color:#ffc107;">{{ $order->status }}</h3>
                        <p class="text-muted">Pesanan Anda sedang kami proses. Terima kasih telah berbelanja di Kestore.id!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
