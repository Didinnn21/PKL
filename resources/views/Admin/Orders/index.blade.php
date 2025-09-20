@extends('layouts.dashboard')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Kelola Pesanan</h1>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Semua Pesanan</span>
                <div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark-custom table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Contoh Data --}}
                            <tr>
                                <td><strong>#KESTORE-001</strong></td>
                                <td>Andi Budianto</td>
                                <td>19 Sep 2025</td>
                                <td>Rp 150.000</td>
                                <td><span class="badge" style="background-color:#d4af37; color:#1a1a1a;">Sedang
                                        Diproses</span></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-light">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#KESTORE-002</strong></td>
                                <td>Citra Lestari</td>
                                <td>18 Sep 2025</td>
                                <td>Rp 275.000</td>
                                <td><span class="badge" style="background-color:#ffc107; color:#1a1a1a;">Menunggu
                                        Pembayaran</span></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-light">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#KESTORE-003</strong></td>
                                <td>Doni Setiawan</td>
                                <td>15 Sep 2025</td>
                                <td>Rp 550.000</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-light">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
