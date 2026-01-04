@extends('layouts.dashboard')

@section('title', 'Laporan Penjualan Tahunan')

@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary text-white">Laporan Penjualan</h1>

        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card h-100 border-secondary" style="background-color: #1a1a1a;">
                    <div class="card-header border-secondary text-warning fw-bold">
                        <i class="fas fa-chart-bar me-2"></i> Grafik Pendapatan (12 Bulan Terakhir)
                    </div>
                    <div class="card-body">
                        <div style="height: 400px; position: relative; width: 100%;">
                            <canvas id="salesReportChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100 border-secondary" style="background-color: #1a1a1a;">
                    <div class="card-header border-secondary text-warning fw-bold">
                        <i class="fas fa-tshirt me-2"></i> 5 Produk Terlaris
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($top_products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="background-color: transparent; color: #f0f0f0; border-bottom: 1px solid #333;">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-secondary me-3 rounded-circle"
                                              style="width:25px; height:25px; display:flex; justify-content:center; align-items:center;">
                                            {{ $loop->iteration }}
                                        </span>
                                        <div>
                                            <span class="fw-medium text-white d-block">{{ $product->name }}</span>
                                            <small class="text-white-50" style="font-size: 0.75rem;">Item Populer</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning text-dark rounded-pill fw-bold">
                                        {{ $product->sold }} Terjual
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-secondary" style="background-color: #1a1a1a;">
                    <div class="card-header border-secondary text-warning fw-bold">
                        <i class="fas fa-users me-2"></i> Top 5 Pelanggan Sultan (Belanja Terbanyak)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0" style="background-color: #1a1a1a;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #444;">
                                        <th class="text-warning ps-4" style="width: 50px;">#</th>
                                        <th class="text-warning">Nama Pelanggan</th>
                                        <th class="text-warning">Email</th>
                                        <th class="text-warning text-center">Total Transaksi</th>
                                        <th class="text-warning text-end pe-4">Total Belanja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($top_customers as $customer)
                                        <tr style="border-bottom: 1px solid #333;">
                                            <td class="ps-4 py-3 align-middle">{{ $loop->iteration }}</td>
                                            <td class="py-3 align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-dark border border-secondary d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px; font-size: 1rem;">
                                                        <i class="fas fa-user text-warning"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-white d-block" style="font-size: 1rem;">
                                                            {{ $customer->name }}
                                                        </span>
                                                        <small class="badge bg-warning text-dark" style="font-size: 0.65rem;">MEMBER</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-3 align-middle text-white-50">
                                                {{ $customer->email }}
                                            </td>

                                            <td class="py-3 align-middle text-center">
                                                <span class="badge bg-secondary text-white">
                                                    {{ $customer->transactions }}x Order
                                                </span>
                                            </td>
                                            <td class="py-3 align-middle text-end pe-4">
                                                <h5 class="mb-0 fw-bold text-warning">
                                                    Rp {{ number_format($customer->total, 0, ',', '.') }}
                                                </h5>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-white-50 py-4">Belum ada data pelanggan.</td>
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
        Chart.register(ChartDataLabels);

        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0
            }).format(value);
        };

        const rawData = @json($salesChartData['data']);
        const labelsData = @json($salesChartData['labels']);
        const cleanData = rawData.map(val => parseFloat(val));
        const salesCtx = document.getElementById('salesReportChart').getContext('2d');
        const gradient = salesCtx.createLinearGradient(0, 0, 0, 400);

        gradient.addColorStop(0, '#ffd700');
        gradient.addColorStop(1, '#b8860b');

        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Pendapatan',
                    data: cleanData,
                    backgroundColor: gradient,
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    borderRadius: 5,
                    barPercentage: 0.6,
                    hoverBackgroundColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 30 } },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.9)',
                        titleColor: '#d4af37',
                        bodyColor: '#fff',
                        borderColor: '#d4af37',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: { label: (c) => ' Total: ' + formatRupiah(c.parsed.y) }
                    },
                    datalabels: {
                        anchor: 'end', align: 'top', color: '#ffffff',
                        font: { weight: 'bold', size: 10 },
                        formatter: (val) => val > 0 ? formatRupiah(val) : ''
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#ffffff', font: { size: 11 }, stepSize: 500000, callback: (v) => formatRupiah(v) },
                        grid: { color: 'rgba(255, 255, 255, 0.15)', borderDash: [4, 4] },
                        border: { display: false }
                    },
                    x: {
                        ticks: { color: '#ffffff', font: { size: 11, weight: 'bold' } },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
