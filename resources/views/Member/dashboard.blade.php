@extends('layouts.member')

@section('title', 'Dashboard')

@push('styles')
    <style>
        /* Mengatur ulang breadcrumb agar sesuai tema */
        .breadcrumb {
            background-color: transparent !important;
            padding-left: 0;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        /* Kartu statistik kecil */
        .stat-card-sm {
            background: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            color: var(--text-light);
            padding: 1.5rem;
        }

        .stat-card-sm .stat-icon {
            font-size: 1.5rem;
            color: var(--primary-gold);
        }

        .stat-card-sm .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .stat-card-sm .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Kartu utama untuk pesanan */
        .card-orders {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
        }

        .card-orders .card-header {
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
            font-weight: 600;
        }

        /* Tabel yang lebih rapi */
        .table-custom {
            color: var(--text-light);
        }

        .table-custom thead th {
            border-bottom-width: 1px !important;
            border-color: var(--dark-border) !important;
            color: var(--text-muted);
            font-weight: 500;
            padding: 1rem;
        }

        .table-custom tbody td {
            border-color: var(--dark-border) !important;
            vertical-align: middle;
            padding: 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: var(--dark-surface);
            color: #fff;
        }

        /* Styling badge yang konsisten */
        .badge-status {
            font-size: 0.75rem;
            padding: 0.4em 0.8em;
            font-weight: 600;
        }

        .badge-status-menunggu {
            background-color: rgba(212, 175, 55, 0.15);
            color: var(--primary-gold);
            border: 1px solid rgba(212, 175, 55, 0.4);
        }

        .badge-status-selesai {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.4);
        }

        .btn-outline-gold {
            color: var(--primary-gold);
            border-color: var(--primary-gold);
        }

        .btn-outline-gold:hover {
            color: var(--dark-bg);
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mt-4">Dashboard</h1>
            <a href="{{ route('member.products.index') }}" class="btn btn-outline-gold mt-4">
                <i class="fas fa-plus me-2"></i>Buat Pesanan Baru
            </a>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat Datang kembali, {{ Auth::user()->name }}!</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="background-color: rgba(40, 167, 69, 0.2); border-color: #28a745; color:#28a745;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="stat-card-sm h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3"><i class="fas fa-shopping-cart"></i></div>
                        <div>
                            <div class="stat-value">{{ $orders->total() }}</div>
                            <div class="stat-label">Total Pesanan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="stat-card-sm h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3"><i class="fas fa-hourglass-half"></i></div>
                        <div>
                            <div class="stat-value">{{ $orders->where('status', 'Menunggu Pembayaran')->count() }}</div>
                            <div class="stat-label">Pesanan Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="stat-card-sm h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="stat-value">{{ $orders->where('status', 'Selesai')->count() }}</div>
                            <div class="stat-label">Pesanan Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-orders mb-4">
            <div class="card-header">
                <i class="fas fa-history me-1"></i>
                Riwayat Pesanan Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-custom table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Produk</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-end">Total Harga</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><strong>#KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>
                                        {{ $order->product->name ?? 'N/A' }}
                                        <small class="d-block text-muted">Jumlah: {{ $order->quantity }} pcs</small>
                                    </td>
                                    <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="text-end">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill badge-status badge-status-menunggu">{{ $order->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('member.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-outline-gold">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Anda belum memiliki riwayat pesanan.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($orders->hasPages())
                <div class="card-footer" style="background-color: var(--dark-surface);">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
