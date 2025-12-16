@extends('layouts.dashboard')
@section('title', 'Kelola Pesanan')
@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Manajemen Pesanan</h1>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td><strong>#KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->product->name ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td><span class="badge"
                                            style="background-color:#ffc107; color:#1a1a1a;">{{ $order->status }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-outline-light"><i class="fas fa-eye me-1"></i> Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada pesanan yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
@endsection
