@extends('layouts.member')

@section('title', 'Dashboard')

@push('styles')
    <style>
        .stat-card {
            background: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            color: var(--text-light);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.1);
        }

        .stat-card .stat-icon {
            font-size: 1.75rem;
            color: var(--primary-gold);
        }

        .stat-card .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: #fff;
        }

        .stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .card-main {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            height: 100%;
        }

        .card-main .card-header {
            background-color: var(--dark-surface);
            border-bottom: 1px solid var(--dark-border);
            font-weight: 600;
        }

        .table-custom tbody tr:hover {
            background-color: var(--dark-surface);
        }

        .badge-status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            padding: 0.4em 0.8em;
        }

        .badge-status-selesai {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
            padding: 0.4em 0.8em;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 pt-1" style="color:var(--text-light);">Dashboard</h1>
                <p>Selamat Datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold">
                <i class="fas fa-plus me-2"></i>Buat Pesanan Baru
            </a>
        </div>

        {{-- Kartu Statistik Animasi --}}
        <div class="row g-4">
            <div class="col-xl-4 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Pesanan</div>
                            <div class="stat-value" data-target="{{ $totalPesanan }}">0</div>
                        </div>
                        <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Pesanan Aktif</div>
                            <div class="stat-value" data-target="{{ $pesananAktif }}">0</div>
                        </div>
                        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Pesanan Selesai</div>
                            <div class="stat-value" data-target="{{ $pesananSelesai }}">0</div>
                        </div>
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            {{-- Tabel Riwayat Pesanan Terbaru --}}
            <div class="col-lg-8">
                <div class="card card-main">
                    <div class="card-header"><i class="fas fa-history me-2"></i>Riwayat Pesanan Terbaru</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover align-middle">
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td><strong>#KESTORE-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                            <td>{{ $order->product->name ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge rounded-pill {{ strtolower($order->status) == 'selesai' ? 'badge-status-selesai' : 'badge-status-pending' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="text-end"><a href="{{ route('member.orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-outline-light">Detail</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                                <h6 class="text-muted">Anda belum memiliki riwayat pesanan.</h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Grafik Status Pesanan --}}
            <div class="col-lg-4">
                <div class="card card-main">
                    <div class="card-header"><i class="fas fa-chart-pie me-2"></i>Ringkasan Status Pesanan</div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Animasi Angka pada Kartu Statistik
            const counters = document.querySelectorAll('.stat-value');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                if (target === 0) return;

                const animate = (timestamp) => {
                    const count = +counter.innerText;
                    const inc = Math.ceil(target / 100);

                    if (count < target) {
                        counter.innerText = Math.min(count + inc, target);
                        setTimeout(animate, 15);
                    } else {
                        counter.innerText = target;
                    }
                }
                animate();
            });

            // Inisialisasi Grafik Donat (Chart.js)
            if (document.getElementById('orderStatusChart')) {
                const ctx = document.getElementById('orderStatusChart').getContext('2d');
                const orderStatusData = @json($orderStatusData);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(orderStatusData),
                        datasets: [{
                            data: Object.values(orderStatusData),
                            backgroundColor: ['rgba(40, 167, 69, 0.7)', 'rgba(255, 193, 7, 0.7)', 'rgba(23, 162, 184, 0.7)', 'rgba(220, 53, 69, 0.7)'],
                            borderColor: 'var(--dark-surface-2)',
                            borderWidth: 4,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: 'var(--text-muted)', boxWidth: 12, padding: 20 }
                            }
                        },
                        animation: { animateScale: true, animateRotate: true }
                    }
                });
            }
        });
    </script>
@endpush
