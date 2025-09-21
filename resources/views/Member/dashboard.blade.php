@extends('layouts.member')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard Member</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat datang, {{ Auth::user()->name }}</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Riwayat Pesanan Anda
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Tanggal Pesan</th>
                                <th>Desain</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($order->status == 'Pending') badge-warning
                                            @elseif($order->status == 'Processing') badge-info
                                            @elseif($order->status == 'Completed') badge-success
                                            @else badge-danger
                                            @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        {{-- PERBAIKAN DI SINI --}}
                                        @if($order->design_file)
                                            <a href="{{ asset('storage/' . $order->design_file) }}"
                                                class="btn btn-sm btn-outline-primary" download>
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Anda belum memiliki pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
