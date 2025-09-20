@extends('layouts.dashboard')

@section('title', 'Data Pembeli')

@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Data Pembeli</h1>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark-custom table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Total Pesanan</th>
                                <th>Total Belanja</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Contoh Data --}}
                            <tr>
                                <td>Andi Budianto</td>
                                <td>andi.b@example.com</td>
                                <td>5 Pesanan</td>
                                <td>Rp 1.250.000</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-light">Lihat Riwayat</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Citra Lestari</td>
                                <td>citra.l@example.com</td>
                                <td>8 Pesanan</td>
                                <td>Rp 3.450.000</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-light">Lihat Riwayat</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Doni Setiawan</td>
                                <td>doni.s@example.com</td>
                                <td>2 Pesanan</td>
                                <td>Rp 750.000</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-light">Lihat Riwayat</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
