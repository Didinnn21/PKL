@extends('layouts.dashboard')
@section('title', 'Laporan Penjualan')
@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Laporan Penjualan</h1>
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Grafik Pendapatan (6 Bulan Terakhir)</div>
                    <div class="card-body"><canvas id="salesReportChart"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Produk Terlaris</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($top_products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="background:none; color: #fff;">
                                    {{ $product->name }} <span class="badge bg-warning rounded-pill">{{ $product->sold }}
                                        Terjual</span>
                                </li>
                            @empty
                                <li class="list-group-item" style="background:none; color: #fff;">Belum ada data penjualan.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const salesCtx = document.getElementById('salesReportChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: @json($salesChartData['labels']),
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: @json($salesChartData['data']),
                        backgroundColor: '#d4af37',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { labels: { color: '#fff' } } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#ccc' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                        x: { ticks: { color: '#ccc' }, grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endpush
