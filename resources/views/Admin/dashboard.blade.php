@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        .stat-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #2c2c2c, #1e1e1e);
            border: 1px solid var(--dark-border);
            color: var(--text-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .stat-card .stat-icon {
            font-size: 3rem;
            color: var(--primary-gold);
            opacity: 0.15;
            position: absolute;
            right: -15px;
            bottom: -15px;
            transform: rotate(-15deg);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(0deg) scale(1.1);
            opacity: 0.2;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .filter-buttons .btn {
            background-color: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-muted);
        }

        .filter-buttons .btn.active {
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
            color: var(--dark-bg);
            font-weight: 600;
        }

        .badge-status-menunggu {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.4);
        }

        .badge-status-selesai {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.4);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 page-header">
            <h1 class="h2">Beranda</h1>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="stat-label">Pendapatan Hari Ini</div>
                        <div class="stat-value">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}
                        </div>
                        <i class="fas fa-dollar-sign stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="stat-label">Pesanan Baru</div>
                        <div class="stat-value">{{ $stats['pesanan_baru'] ?? 0 }}</div>
                        <i class="fas fa-shopping-cart stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="stat-label">Pelanggan Baru (Hari ini)</div>
                        <div class="stat-value">{{ $stats['pelanggan_baru'] ?? 0 }}</div>
                        <i class="fas fa-user-plus stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-value">{{ $stats['total_produk'] ?? 0 }}</div>
                        <i class="fas fa-box-open stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-chart-line me-2"></i>Tinjauan Penjualan</span>
                        <div class="btn-group btn-group-sm filter-buttons" role="group">
                            <a href="?filter=weekly" class="btn {{ $filter === 'weekly' ? 'active' : '' }}">Mingguan</a>
                            <a href="?filter=monthly" class="btn {{ $filter === 'monthly' ? 'active' : '' }}">Bulanan</a>
                            <a href="?filter=yearly" class="btn {{ $filter === 'yearly' ? 'active' : '' }}">Tahunan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-4">
                <div class="card">
                    <div class="card-header"><i class="fas fa-history me-2"></i>Pesanan Terbaru</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <tbody>
                                    @forelse($pesanan_terbaru as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                                <small
                                                    class="text-muted">#KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</small>
                                            </td>
                                            <td class="text-end">
                                                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong><br>
                                                <span
                                                    class="badge rounded-pill badge-status-menunggu">{{ $order->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center py-4 text-muted">Belum ada pesanan terbaru.</td>
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
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($salesChartData['labels']),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($salesChartData['data']),
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
                        borderColor: 'rgba(212, 175, 55, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(212, 175, 55, 1)',
                        pointRadius: 4,
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                callback: function (value) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(value); }
                            },
                            grid: { color: 'rgba(255,255,255,0.1)' }
                        },
                        x: {
                            ticks: { color: 'rgba(255, 255, 255, 0.7)' },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
