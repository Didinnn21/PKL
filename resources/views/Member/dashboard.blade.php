@extends('layouts.member')

@section('title', 'Dashboard Member')

@push('styles')
    <style>
        .stat-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
            color: var(--text-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.15);
        }

        .stat-card .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-gold);
            opacity: 0.8;
        }

        .stat-card .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: #fff;
        }

        .stat-card .stat-label {
            font-size: 1rem;
            color: var(--text-muted);
        }

        .chart-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-1 pb-2 mb-4" style="color:var(--text-light); border-bottom: 1px solid var(--dark-border);">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>

        {{-- Kartu Statistik Animasi --}}
        <div class="row g-4">
            <div class="col-md-6">
                <div class="stat-card d-flex align-items-center">
                    <div class="stat-icon me-4"><i class="fas fa-box-open"></i></div>
                    <div>
                        <div class="stat-value" data-target="{{ $totalOrders }}">0</div>
                        <div class="stat-label">Total Pesanan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card d-flex align-items-center">
                    <div class="stat-icon me-4"><i class="fas fa-wallet"></i></div>
                    <div>
                        <div class="stat-value" data-target="{{ $totalSpent }}" data-prefix="Rp ">0</div>
                        <div class="stat-label">Total Belanja</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Animasi --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-card">
                    <h5 class="mb-3">Riwayat Belanja (6 Bulan Terakhir)</h5>
                    <canvas id="spendingChart" style="min-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Animasi Angka pada Kartu Statistik
            const counters = document.querySelectorAll('.stat-value');
            counters.forEach(counter => {
                const animate = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText.replace(/[^0-9]/g, '');
                    const prefix = counter.getAttribute('data-prefix') || '';
                    const inc = Math.ceil(target / 100); // Kecepatan animasi

                    if (count < target) {
                        const newValue = Math.min(count + inc, target);
                        counter.innerText = prefix + (prefix ? newValue.toLocaleString('id-ID') : newValue);
                        setTimeout(animate, 15);
                    } else {
                        counter.innerText = prefix + (prefix ? target.toLocaleString('id-ID') : target);
                    }
                }
                animate();
            });

            // 2. Inisialisasi Grafik (Chart.js)
            if (document.getElementById('spendingChart')) {
                const ctx = document.getElementById('spendingChart').getContext('2d');
                const spendingChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Total Belanja',
                            data: {!! json_encode($chartValues) !!},
                            backgroundColor: 'rgba(212, 175, 55, 0.6)',
                            borderColor: 'rgba(212, 175, 55, 1)',
                            borderWidth: 1,
                            borderRadius: 5,
                            hoverBackgroundColor: 'rgba(212, 175, 55, 0.8)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { color: 'var(--text-muted)', callback: (value) => 'Rp ' + value.toLocaleString('id-ID') },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' }
                            },
                            x: {
                                ticks: { color: 'var(--text-muted)' },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'var(--dark-bg)',
                                titleColor: 'var(--text-light)',
                                bodyColor: 'var(--text-muted)',
                                callbacks: {
                                    label: function (context) {
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed.y !== null) {
                                            label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        animation: { duration: 1200, easing: 'easeInOutQuart' }
                    }
                });
            }
        });
    </script>
@endpush
