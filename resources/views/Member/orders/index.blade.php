@extends('layouts.member')
@section('title', 'Pesanan Saya')
@push('styles')
    <style>
        .card-orders {
            background-color: #2c2c2c;
            border: 1px solid #444;
            border-radius: 12px;
        }

        .card-orders .card-header {
            background-color: #2c2c2c;
            border-bottom: 1px solid #444;
        }

        .table-dark-custom {
            color: #e0e0e0;
        }

        .table-dark-custom th {
            border-color: #444 !important;
            font-weight: 600;
            color: #aaa;
        }

        .table-dark-custom td,
        .table-dark-custom th {
            border-color: #444 !important;
        }

        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .badge-status {
            font-size: 0.8rem;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-status-menunggu {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .badge-status-selesai {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-4 border-bottom border-secondary">Riwayat Pesanan Saya</h1>
        <div class="card card-orders">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="py-3 px-4">ID Pesanan</th>
                                <th class="py-3 px-4">Produk</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Total</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-4"><strong>#KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($order->product->image_url ?? '') }}" class="product-thumbnail">
                                            <span>{{ $order->product->name }} ({{ $order->quantity }}x)</span>
                                        </div>
                                    </td>
                                    <td class="px-4">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-4"><span class="badge badge-status-menunggu">{{ $order->status }}</span></td>
                                    <td class="px-4 text-center">
                                        <a href="{{ route('member.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-outline-light">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <h5>Anda belum memiliki riwayat pesanan.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($orders->hasPages())
                <div class="card-footer" style="background-color:#333;">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
@endsection
