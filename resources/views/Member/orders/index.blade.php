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
                                        <th class="py-3">Tanggal</th>
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
                                                    {{-- Cek Gambar: Jika Custom (product_id null) pakai ikon, jika Produk pakai
                                                    gambar --}}
                                                    @if($order->product)
                                                        <img src="{{ asset('images/product/' . $order->product->image) }}"
                                                            class="rounded border border-secondary me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
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
                                            <td class="text-white">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="text-warning fw-bold">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @if($order->status == 'Menunggu Pembayaran')
                                                    <span class="badge bg-warning text-dark border border-warning">Menunggu
                                                        Pembayaran</span>
                                                @elseif($order->status == 'Menunggu Verifikasi')
                                                    <span class="badge bg-info text-dark border border-info">Verifikasi Admin</span>
                                                @elseif($order->status == 'Menunggu Konfirmasi')
                                                    <span class="badge bg-secondary text-white border border-secondary">Menunggu
                                                        Harga</span>
                                                @elseif(in_array($order->status, ['Lunas', 'Selesai', 'Dikirim']))
                                                    <span
                                                        class="badge bg-success text-white border border-success">{{ $order->status }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-white border border-danger">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('member.orders.show', $order->id) }}"
                                                    class="btn btn-outline-light btn-sm">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                                <p class="mb-0">Anda belum memiliki riwayat pesanan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination Links --}}
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