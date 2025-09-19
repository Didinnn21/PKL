@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@push('styles')
    <style>
        .stats-card {
            background-color: #2c2c2c;
            border: 1px solid #444;
            border-radius: 8px;
            color: #fff;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .stats-card .icon {
            font-size: 2.5rem;
            color: #d4af37;
        }

        .stats-card .stat-title {
            font-size: 0.9rem;
            color: #ccc;
        }

        .stats-card .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .card-chart,
        .card-table {
            background-color: #2c2c2c;
            border: 1px solid #444;
            border-radius: 8px;
        }

        .table-dark-custom {
            background-color: #2c2c2c;
            color: #f0f0f0;
        }

        .table-dark-custom th {
            background-color: #333;
            border-color: #444 !important;
        }

        .table-dark-custom td,
        .table-dark-custom th {
            border-color: #444 !important;
        }

        .badge-status-proses {
            background-color: #d4af37;
            color: #1a1a1a;
        }

        .badge-status-tunggu {
            background-color: #ffc107;
            color: #1a1a1a;
        }

        .badge-status-kirim {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-status-selesai {
            background-color: #28a745;
            color: #fff;
        }

        /* PERBAIKAN WARNA TOMBOL DETAIL */
        .table-dark-custom .btn-outline-light {
            color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .table-dark-custom .btn-outline-light:hover {
            color: #1a1a1a;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
            <h1 class="h2">Admin Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Produk Baru
                </a>
            </div>
        </div>

        <!-- Opsi 1: Kartu Statistik Utama -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-title">PENDAPATAN HARI INI</div>
                            <div class="stat-value">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</div>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-title">PESANAN BARU</div>
                            <div class="stat-value">{{ $stats['pesanan_baru'] }}</div>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-bag"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-title">PELANGGAN BARU</div>
                            <div class="stat-value">{{ $stats['pelanggan_baru'] }}</div>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-title">TOTAL PRODUK</div>
                            <div class="stat-value">{{ $stats['total_produk'] }}</div>
                        </div>
                        <div class="icon"><i class="fas fa-box-open"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Opsi 2: Grafik Visual dengan Filter -->
        <div class="row mt-4">
            <div class="col-lg-7 mb-4">
                <div class="card card-chart">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-chart-line me-2"></i> Grafik Penjualan</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('admin.dashboard', ['filter' => 'weekly']) }}"
                                class="btn btn-outline-secondary {{ $filter == 'weekly' ? 'active' : '' }}">Mingguan</a>
                            <a href="{{ route('admin.dashboard', ['filter' => 'monthly']) }}"
                                class="btn btn-outline-secondary {{ $filter == 'monthly' ? 'active' : '' }}">Bulanan</a>
                            <a href="{{ route('admin.dashboard', ['filter' => 'yearly']) }}"
                                class="btn btn-outline-secondary {{ $filter == 'yearly' ? 'active' : '' }}">Tahunan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mb-4">
                <div class="card card-chart">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-chart-pie me-2"></i> Kategori Populer
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Opsi 3: Tabel Informasi Cepat -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-table">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-receipt me-2"></i> Pesanan Terbaru
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark-custom table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Pelanggan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pesanan_terbaru as $pesanan)
                                        <tr>
                                            <td><strong>{{ $pesanan['id'] }}</strong></td>
                                            <td>{{ $pesanan['pelanggan'] }}</td>
                                            <td>Rp {{ number_format($pesanan['total'], 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $statusClass = 'badge-status-proses';
                                                    if ($pesanan['status'] == 'Menunggu Pembayaran')
                                                        $statusClass = 'badge-status-tunggu';
                                                    if ($pesanan['status'] == 'Telah Dikirim')
                                                        $statusClass = 'badge-status-kirim';
                                                    if ($pesanan['status'] == 'Selesai')
                                                        $statusClass = 'badge-status-selesai';
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $pesanan['status'] }}</span>
                                            </td>
                                            <td><a href="#" class="btn btn-sm btn-outline-light">Detail</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada pesanan terbaru.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($salesChartData['labels']),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($salesChartData['data']),
                        borderColor: '#d4af37',
                        backgroundColor: 'rgba(212, 175, 55, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { labels: { color: '#fff' } } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#ccc' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                        x: { ticks: { color: '#ccc' }, grid: { color: 'rgba(255,255,255,0.1)' } }
                    }
                }
            });

            // Category Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Kaos', 'Hoodie', 'Crewneck'],
                    datasets: [{
                        data: [55, 30, 15],
                        backgroundColor: ['#d4af37', '#a08153', '#6c757d'],
                        borderColor: '#2c2c2c',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#fff' } },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = (value * 100 / sum).toFixed(1) + "%";
                                return percentage;
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14,
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels],
            });
        });
    </script>
@endpush
