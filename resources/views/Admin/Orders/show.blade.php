@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Detail Pesanan #{{ $order->id }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pesanan</a></li>
            <li class="breadcrumb-item active">Detail Pesanan</li>
        </ol>
        <div class="card">
            <div class="card-header">
                Informasi Pesanan
            </div>
            <div class="card-body">
                <p><strong>Nama Pelanggan:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Produk:</strong> {{ $order->product->name }}</p>
                <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $order->status }}</p>
                <p><strong>Catatan:</strong> {{ $order->notes ?? '-' }}</p>
                <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address ?? 'Alamat belum diisi.' }}</p>

                @if($order->design_file)
                    <p><strong>File Desain:</strong>
                        <a href="{{ asset('storage/' . $order->design_file) }}" download>Unduh Desain</a>
                    </p>
                @endif
                <hr>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
