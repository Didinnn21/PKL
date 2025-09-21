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
                                <th>Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->orders_count }} Pesanan</td>
                                    <td>Rp {{ number_format($customer->orders_sum_total_price, 0, ',', '.') }}</td>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada pembeli yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $customers->links() }}</div>
            </div>
        </div>
    </div>
@endsection
