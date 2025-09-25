@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@push('styles')
    <style>
        /* ... CSS Anda ... */
    </style>
@endpush

@section('content')
    <div class="container-fluid px-0">
        <div class="row">
            {{-- Total Products --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="small text-white-50">Total Products</div>
                                <div class="h2">{{ number_format($stats['total_products']) }}</div>
                            </div>
                            <div class="align-self-center"><i class="fas fa-box fa-2x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total Orders --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="small text-white-50">Total Orders</div>
                                <div class="h2">{{ number_format($stats['total_orders']) }}</div>
                            </div>
                            <div class="align-self-center"><i class="fas fa-shopping-cart fa-2x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total Customers --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="small text-white-50">Total Customers</div>
                                <div class="h2">{{ number_format($stats['total_customers']) }}</div>
                            </div>
                            <div class="align-self-center"><i class="fas fa-users fa-2x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total Revenue --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="small text-white-50">Total Revenue</div>
                                <div class="h2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                            </div>
                            <div class="align-self-center"><i class="fas fa-money-bill-wave fa-2x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4 text-white">
                    <div class="card-header"><i class="fas fa-chart-area me-1"></i> Sales Overview (8 Bulan)</div>
                    <div class="card-body"><canvas id="salesChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 text-white">
                    <div class="card-header"><i class="fas fa-star me-1"></i> Top Selling Products</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Units Sold</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($top_products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3"><i class="fas {{ $product['icon'] ?? 'fa-box' }}"></i></div>
                                                    <strong>{{ $product['name'] }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ number_format($product['sold']) }} units</td>
                                            <td><strong>Rp {{ number_format($product['revenue']) }}</strong></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center">Data produk terlaris tidak ditemukan.</td></tr>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($salesChartData['labels']),
                    datasets: [{
                        label: 'Sales (in Million Rp)',
                        data: @json($salesChartData['data']),
                        borderColor: '#d4af37',
                        backgroundColor: 'rgba(212, 175, 55, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#d4af37',
                        pointBorderColor: '#fff'
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
        });
    </script>
@endpush
