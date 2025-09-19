@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@push('styles')
    {{-- Menambahkan style custom untuk tema Kestore.id --}}
    <style>
        .stats-card {
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            border: 1px solid #444;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .stats-card .fa-box,
        .stats-card .fa-shopping-cart,
        .stats-card .fa-users,
        .stats-card .fa-money-bill-wave {
            color: #d4af37;
            /* Aksen emas untuk ikon */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-0">
        <!-- Stats Cards -->
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
                            <div class="align-self-center">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
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
                            <div class="align-self-center">
                                <i class="fas fa-shopping-cart fa-2x"></i>
                            </div>
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
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
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
                            <div class="align-self-center">
                                <i class="fas fa-money-bill-wave fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sales Chart -->
            <div class="col-xl-8">
                <div class="card mb-4 text-white">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i> Sales Overview
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>

            <!-- Category Distribution Chart -->
            <div class="col-xl-4">
                <div class="card mb-4 text-white">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i> Category Distribution
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" width="100%" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products Table -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 text-white">
                    <div class="card-header">
                        <i class="fas fa-star me-1"></i> Top Selling Products
                    </div>
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
                                    @foreach($top_products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <i class="fas {{ $product['icon'] ?? 'fa-box' }}"></i>
                                                    </div>
                                                    <strong>{{ $product['name'] }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ number_format($product['sold']) }} units</td>
                                            <td><strong>Rp {{ number_format($product['revenue']) }}</strong></td>
                                        </tr>
                                    @endforeach
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
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                datasets: [{
                    label: 'Sales (in Million Rp)',
                    data: [12, 19, 8, 15, 25, 22, 30, 28],
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

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Kaos/Crewneck', 'Hoodie/Sweater', 'Topi', 'Pakaian Bayi'],
                datasets: [{
                    data: [65, 20, 10, 5],
                    backgroundColor: ['#d4af37', '#a08153', '#6c757d', '#343a40'],
                    borderColor: '#2c2c2c',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#fff' }
                    }
                }
            }
        });
    </script>
@endpush
