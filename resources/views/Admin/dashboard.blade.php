@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
        <h1 class="h2 text-white">Dashboard</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-warning text-white">
                    <i class="fas fa-share-alt me-1"></i> Bagikan
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning text-white">
                    <i class="fas fa-download me-1"></i> Ekspor
                </button>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 h-100 shadow-sm py-2" style="background-color: #1a1a1a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Pendapatan (Hari Ini)</div>
                            <div class="h5 mb-0 fw-bold text-white">
                                Rp {{ number_format($todays_earnings, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 h-100 shadow-sm py-2" style="background-color: #1a1a1a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Pesanan Baru (Hari Ini)</div>
                            <div class="h5 mb-0 fw-bold text-white">{{ $new_orders }} Pesanan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 h-100 shadow-sm py-2" style="background-color: #1a1a1a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Total Produk</div>
                            <div class="h5 mb-0 fw-bold text-white">{{ $total_products }} Item</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 h-100 shadow-sm py-2" style="background-color: #1a1a1a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Pelanggan</div>
                            <div class="h5 mb-0 fw-bold text-white">{{ $total_customers }} Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card h-100 border-secondary" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-warning">
                        <i class="fas fa-chart-area me-1"></i> Tren Penjualan (7 Hari Terakhir)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px; position: relative;">
                        <canvas id="dashboardSalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-secondary" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary">
                    <h6 class="m-0 fw-bold text-warning">
                        <i class="fas fa-receipt me-1"></i> Pesanan Terbaru
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recent_orders as $order)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-3 py-3"
                                 style="background-color: transparent; color: #fff; border-bottom: 1px solid #333;">
                                <div>
                                    <div class="fw-bold text-white">#ORD-{{ $order->id }}</div>
                                    <small class="text-white-50">
                                        {{ $order->user->name ?? 'Tamu' }} &bull; {{ $order->created_at->translatedFormat('d M H:i') }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-warning" style="font-size: 0.9rem;">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </div>

                                    @php
                                        $statusColor = 'secondary';
                                        $statusText = $order->status;

                                        if($order->status == 'Menunggu Pembayaran') { $statusColor = 'warning text-dark'; $statusText = 'Menunggu'; }
                                        elseif($order->status == 'Menunggu Verifikasi') { $statusColor = 'info text-dark'; $statusText = 'Verifikasi'; }
                                        elseif($order->status == 'Diproses') { $statusColor = 'primary'; }
                                        elseif($order->status == 'Dikirim') { $statusColor = 'info'; }
                                        elseif($order->status == 'Selesai') { $statusColor = 'success'; }
                                        elseif($order->status == 'Dibatalkan') { $statusColor = 'danger'; }
                                    @endphp

                                    <span class="badge bg-{{ $statusColor }} rounded-pill" style="font-size: 0.7rem;">
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                Belum ada pesanan masuk.
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer border-secondary text-center bg-transparent">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-warning small fw-bold">
                        Lihat Semua Pesanan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardSalesChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(212, 175, 55, 0.5)');
        gradient.addColorStop(1, 'rgba(212, 175, 55, 0.0)');

        const rawData = @json($chartData['data']);
        const labelsData = @json($chartData['labels']);

        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0
            }).format(value);
        };

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Pendapatan',
                    data: rawData,
                    backgroundColor: gradient,
                    borderColor: '#d4af37',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#d4af37',
                    pointRadius: 4,
                    pointHoverRadius: 6,
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
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#d4af37',
                        bodyColor: '#fff',
                        borderColor: '#444',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                return ' ' + formatRupiah(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#b0b0b0', font: {size: 11} },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#b0b0b0',
                            font: {size: 11},
                            callback: function(value) {
                                if(value >= 1000000) return (value/1000000) + 'jt';
                                if(value >= 1000) return (value/1000) + 'rb';
                                return value;
                            }
                        },
                        grid: { color: 'rgba(255,255,255,0.05)', borderDash: [5,5] },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
