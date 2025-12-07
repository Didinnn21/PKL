@extends('layouts.dashboard')

@section('title', 'Dashboard Overview')

@push('styles')
<style>
    /* Card Statistik */
    .stat-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        border-color: var(--gold-primary);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 4px; height: 100%;
        background-color: var(--gold-primary);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-icon {
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        font-size: 2.5rem;
        color: var(--gold-primary);
        opacity: 0.1;
        transition: all 0.3s;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(10deg);
        opacity: 0.2;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
    }

    /* Badge Status */
    .badge-status {
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        text-transform: uppercase;
    }
    .badge-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.2); }
    .badge-success { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-cancel  { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold text-white mb-0">Dashboard Overview</h2>
            <p class="text-secondary mb-0 small">Ringkasan aktivitas toko Anda hari ini.</p>
        </div>
        <div>
            <span class="badge bg-dark border border-secondary text-light px-3 py-2">
                <i class="far fa-calendar-alt me-2"></i> {{ now()->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}</div>
                <i class="fas fa-wallet stat-icon"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Pesanan Baru</div>
                <div class="stat-value">{{ $stats['pesanan_baru'] ?? 0 }}</div>
                <i class="fas fa-shopping-bag stat-icon"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ $stats['total_produk'] ?? 0 }}</div>
                <i class="fas fa-box-open stat-icon"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Pelanggan Baru</div>
                <div class="stat-value">{{ $stats['pelanggan_baru'] ?? 0 }}</div>
                <i class="fas fa-users stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <span><i class="fas fa-chart-line me-2 text-warning"></i> Grafik Penjualan</span>
                    <div class="btn-group btn-group-sm">
                        <a href="?filter=weekly" class="btn btn-outline-secondary {{ $filter === 'weekly' ? 'active' : '' }}">Minggu</a>
                        <a href="?filter=monthly" class="btn btn-outline-secondary {{ $filter === 'monthly' ? 'active' : '' }}">Bulan</a>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <span><i class="fas fa-history me-2 text-warning"></i> Pesanan Terbaru</span>
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-warning small">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($pesanan_terbaru as $order)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                <i class="fas fa-shopping-bag small"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-white fw-bold">{{ $order->user->name ?? 'Guest' }}</span>
                                                <small class="text-muted">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="text-white fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                        @if($order->status == 'pending')
                                            <span class="badge-status badge-pending">Pending</span>
                                        @elseif($order->status == 'paid' || $order->status == 'completed')
                                            <span class="badge-status badge-success">Selesai</span>
                                        @else
                                            <span class="badge-status badge-cancel">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const salesCtx = document.getElementById('salesChart').getContext('2d');

        // Gradient untuk chart agar terlihat mewah
        let gradient = salesCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(212, 175, 55, 0.3)'); // Emas transparan
        gradient.addColorStop(1, 'rgba(212, 175, 55, 0)');

        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($salesChartData['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($salesChartData['data']),
                    backgroundColor: gradient,
                    borderColor: '#D4AF37', // Emas solid
                    borderWidth: 2,
                    pointBackgroundColor: '#D4AF37',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#D4AF37',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1f1f1f',
                        titleColor: '#fff',
                        bodyColor: '#a3a3a3',
                        borderColor: '#333',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#262626' },
                        ticks: { color: '#a3a3a3' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#a3a3a3' }
                    }
                }
            }
        });
    });
</script>
@endpush
