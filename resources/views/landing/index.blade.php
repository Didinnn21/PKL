<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kestore.id - E-Commerce Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Mengubah background menjadi gradien gelap yang elegan */
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            min-height: 100vh;
            margin: 0;
            color: #e0e0e0;
            /* Warna teks default agar kontras */
        }

        .hero-section {
            background: rgba(40, 40, 40, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .stats-card {
            background: #252525;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            margin-bottom: 1rem;
            color: #e0e0e0;
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            /* Mengubah gradien ikon menjadi coklat keemasan / beige */
            background: linear-gradient(45deg, #a08153, #d4af37);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #f0f0f0;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: #b0b0b0;
            font-weight: 500;
        }

        .dashboard-preview {
            background: #252525;
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            color: #e0e0e0;
        }

        .activity-item {
            background: #333333;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid #d4af37;
            /* Border kiri dengan warna aksen */
        }

        .navbar-custom {
            background: rgba(40, 40, 40, 0.7);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            color: #d4af37 !important;
            /* Warna brand logo dengan aksen keemasan */
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #d4af37 !important;
            /* Warna link saat hover dengan aksen */
        }

        .btn-primary-custom {
            /* Gradien tombol utama dengan nuansa coklat keemasan */
            background: linear-gradient(45deg, #a08153, #d4af37);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-outline-custom {
            border: 2px solid #d4af37;
            /* Border tombol outline dengan warna aksen */
            color: #d4af37;
            /* Warna teks tombol outline dengan warna aksen */
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: #d4af37;
            color: white;
            transform: translateY(-2px);
        }

        .chart-container {
            position: relative;
            height: 300px;
            background: #333333;
            border-radius: 10px;
            padding: 1rem;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-elements::before {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-elements::after {
            bottom: 10%;
            right: 10%;
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Penyesuaian warna teks dan ikon lain */
        h3 {
            color: #f0f0f0;
        }

        .text-primary {
            color: #d4af37 !important;
        }

        .text-warning {
            color: #d4af37 !important;
        }

        .text-success {
            color: #a08153 !important;
        }

        .text-info {
            color: #b0b0b0 !important;
        }

        /* Penyesuaian tabel */
        .table {
            color: #e0e0e0;
        }

        .table-hover tbody tr:hover {
            background-color: #3a3a3a;
        }

        .table-light {
            background-color: #333333 !important;
            color: #f0f0f0;
        }

        .table-light th {
            border-bottom: 1px solid #555555;
        }

        .table tbody tr td {
            border-top: 1px solid #444444;
        }

        .bg-primary {
            background-color: #d4af37 !important;
        }

        .bg-success {
            background-color: #a08153 !important;
        }

        .bg-primary.rounded-circle {
            background-color: #a08153 !important;
        }
    </style>
</head>

<body>
    <div class="floating-elements"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-store me-2"></i>Kestore.id
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                </ul>

                <div class="d-flex">
                    <a href="/login" class="btn btn-outline-custom me-2">Login</a>
                    <a href="/register" class="btn btn-primary-custom">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mt-4">
        <div class="hero-section text-center text-white">
            <h1 class="display-4 fw-bold mb-4">
                Modern E-Commerce Dashboard
            </h1>
            <p class="lead mb-4">
                Kelola toko online Anda dengan mudah menggunakan dashboard yang powerful dan user-friendly
            </p>
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/register" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="#dashboard" class="btn btn-outline-custom btn-lg">
                            <i class="fas fa-play me-2"></i>View Demo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row mt-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stats-number">{{ number_format($stats['total_products']) }}</div>
                    <div class="stats-label">Total Products</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-number">{{ number_format($stats['total_orders']) }}</div>
                    <div class="stats-label">Total Orders</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number">{{ number_format($stats['total_customers']) }}</div>
                    <div class="stats-label">Happy Customers</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-number">Rp {{ number_format($stats['total_revenue'] / 1000000, 1) }}M</div>
                    <div class="stats-label">Total Revenue</div>
                </div>
            </div>
        </div>

        <!-- Dashboard Preview -->
        <div id="dashboard" class="dashboard-preview">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-4">
                        <i class="fas fa-chart-area me-2 text-primary"></i>
                        Real-time Analytics
                    </h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h3 class="mb-4">
                        <i class="fas fa-bell me-2 text-warning"></i>
                        Recent Activities
                    </h3>
                    <div class="activity-list">
                        @foreach($recent_activities as $activity)
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($activity['type'] == 'order')
                                            <i class="fas fa-shopping-cart text-success"></i>
                                        @elseif($activity['type'] == 'product')
                                            <i class="fas fa-box text-info"></i>
                                        @else
                                            <i class="fas fa-user text-warning"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">{{ $activity['message'] }}</div>
                                        <small class="text-muted">{{ $activity['time'] }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">
                        <i class="fas fa-star me-2 text-warning"></i>
                        Top Selling Products
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle me-3"
                                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-mobile-alt text-white"></i>
                                                </div>
                                                <strong>{{ $product['name'] }}</strong>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">{{ $product['sold'] }} units</span></td>
                                        <td><strong>Rp {{ number_format($product['revenue']) }}</strong></td>
                                        <td><span class="badge bg-success">In Stock</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="row mt-5 mb-5">
            <div class="col-12 text-center text-white mb-5">
                <h2 class="display-5 fw-bold">Powerful Features</h2>
                <p class="lead">Everything you need to manage your e-commerce business</p>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stats-card h-100">
                    <div class="stats-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h5 class="mt-3">Real-time Dashboard</h5>
                    <p class="text-muted">Monitor your business performance with real-time analytics and insights.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stats-card h-100">
                    <div class="stats-icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <h5 class="mt-3">Inventory Management</h5>
                    <p class="text-muted">Track stock levels, manage suppliers, and automate reordering processes.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stats-card h-100">
                    <div class="stats-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h5 class="mt-3">Advanced Reports</h5>
                    <p class="text-muted">Generate detailed reports on sales, customers, and product performance.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-4 mt-5">
        <div class="container">
            <p>&copy; 2025 Kestore.id. All rights reserved. Built with ❤️ using Laravel</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue (Million Rp)',
                    data: [12, 19, 8, 15, 25, 22],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
