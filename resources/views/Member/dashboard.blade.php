@extends('layouts.member')

@section('title', 'Dashboard Member')

@section('content')
<div class="container-fluid pt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-secondary shadow-sm" style="background-color: #1a1a1a;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-user-circle fa-3x text-dark"></i>
                        </div>
                        <div>
                            <h2 class="text-white fw-bold mb-1">Halo, {{ Auth::user()->name }}!</h2>
                            <p class="text-white-50 mb-0">Selamat datang kembali di panel member Kestore.id</p>
                        </div>
                    </div>
                    <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold text-dark px-4">
                        <i class="fas fa-shopping-bag me-2"></i> Belanja Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-secondary text-white p-3" style="background-color: #1a1a1a;">
                <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Total Pesanan</small>
                <h3 class="fw-bold mb-0 text-warning">{{ $total_orders }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-secondary text-white p-3" style="background-color: #1a1a1a;">
                <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Sedang Diproses</small>
                <h3 class="fw-bold mb-0 text-info">{{ $pending_orders }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-secondary text-white p-3" style="background-color: #1a1a1a;">
                <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Total Pengeluaran</small>
                <h3 class="fw-bold mb-0 text-success">Rp {{ number_format($total_spent, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-secondary h-100" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary bg-transparent d-flex justify-content-between align-items-center py-3">
                    <h5 class="text-warning fw-bold mb-0"><i class="fas fa-shopping-basket me-2"></i> Pesanan Terakhir</h5>
                    <a href="{{ route('member.orders.index') }}" class="btn btn-outline-warning btn-sm">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr class="text-white-50 small text-uppercase">
                                    <th class="ps-4 border-secondary py-3">ID</th>
                                    <th class="border-secondary py-3">Tanggal</th>
                                    <th class="border-secondary py-3 text-end">Total</th>
                                    <th class="border-secondary py-3 text-center">Status</th>
                                    <th class="pe-4 border-secondary py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders as $order)
                                    <tr class="align-middle border-secondary">
                                        <td class="ps-4">#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->translatedFormat('d M Y') }}</td>
                                        <td class="text-end fw-bold text-warning">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = match($order->status) {
                                                    'Menunggu Pembayaran' => 'bg-warning text-dark',
                                                    'Menunggu Verifikasi' => 'bg-info text-dark',
                                                    'Diproses' => 'bg-primary',
                                                    'Dikirim' => 'bg-info',
                                                    'Selesai' => 'bg-success',
                                                    default => 'bg-danger'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }} rounded-pill" style="font-size: 0.7rem;">{{ $order->status }}</span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-sm btn-dark border-secondary">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-white-50">
                                            <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i><br>
                                            Belum ada pesanan terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-secondary mb-4" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary bg-transparent py-3">
                    <h5 class="text-warning fw-bold mb-0"><i class="fas fa-user-cog me-2"></i> Akun Saya</h5>
                </div>
                <div class="card-body text-white">
                    <div class="mb-3">
                        <small class="text-white-50 d-block">Email</small>
                        <span class="fw-bold">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="mb-4">
                        <small class="text-white-50 d-block">No. Telepon</small>
                        <span>{{ Auth::user()->phone ?? 'Belum diatur' }}</span>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning btn-sm w-100">Edit Profil</a>
                </div>
            </div>

            <div class="card border-secondary" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary bg-transparent py-3">
                    <h5 class="text-warning fw-bold mb-0"><i class="fas fa-star me-2"></i> Rekomendasi</h5>
                </div>
                <div class="card-body">
                    @forelse($products as $product)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $product->image_url ?: 'https://placehold.co/50' }}"
                                 class="rounded me-3 border border-secondary"
                                 style="width: 55px; height: 55px; object-fit: cover;">
                            <div class="overflow-hidden">
                                <h6 class="text-white mb-0 text-truncate small fw-bold">{{ $product->name }}</h6>
                                <span class="text-warning small fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-white-50 small text-center">Belum ada rekomendasi produk.</p>
                    @endforelse
                    <a href="{{ route('member.products.index') }}" class="btn btn-warning btn-sm w-100 fw-bold mt-2 text-dark">
                        Belanja Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
