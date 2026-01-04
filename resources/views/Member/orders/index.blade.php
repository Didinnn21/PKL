@extends('layouts.member')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid pt-4">
    {{-- HEADER HALAMAN --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="text-white fw-bold"><i class="fas fa-history text-warning me-2"></i> Riwayat Pesanan</h4>
                <p class="text-white-50 small mb-0">Daftar transaksi dan status pesanan Anda di Kestore.id</p>
            </div>
            <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold text-dark px-4 shadow-sm">
                <i class="fas fa-shopping-cart me-2"></i> + Pesan Lagi
            </a>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="card border-secondary shadow-lg" style="background-color: #1a1a1a; border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr style="background-color: #000;">
                        <th class="ps-4 py-3 text-warning border-secondary">ID Pesanan</th>
                        <th class="text-warning border-secondary">Produk</th>
                        <th class="text-warning border-secondary text-center">Total Bayar</th>
                        <th class="text-warning border-secondary text-center">Status</th>
                        <th class="text-warning border-secondary text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-secondary">
                        <td class="ps-4 fw-bold text-white-50">#{{ $order->order_number ?? $order->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                {{-- PERBAIKAN LOGIKA: Mendeteksi produk dari tabel Order (Direct) atau OrderItems (Cart) --}}
                                @php
                                    $product = $order->product ?? ($order->items->first() ? $order->items->first()->product : null);

                                    $imagePath = ($product && $product->image)
                                        ? asset('storage/products/' . $product->image)
                                        : asset('images/Slide-2.png');

                                    $productName = $product
                                        ? $product->name
                                        : ($order->order_type == 'custom' ? 'Custom: ' . $order->product_type : 'Produk Kestore');
                                @endphp

                                <img src="{{ $imagePath }}"
                                     class="rounded border border-secondary me-3"
                                     style="width: 50px; height: 50px; object-fit: cover;"
                                     onerror="this.src='{{ asset('images/Slide-2.png') }}'">
                                <div>
                                    <div class="text-white fw-bold small uppercase">{{ $productName }}</div>
                                    <small class="text-white-50">
                                        {{ $order->quantity ?? ($order->items->sum('quantity') ?: 1) }} Item
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="text-warning fw-bold text-nowrap text-center">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @php
                                $statusMap = [
                                    'unpaid' => 'BELUM DIBAYAR',
                                    'pending' => 'BELUM DIBAYAR',
                                    'pending_quote' => 'MENUNGGU QUOTE',
                                    'Menunggu Verifikasi' => 'PROSES VERIFIKASI',
                                    'processing' => 'DIPROSES',
                                    'completed' => 'SELESAI',
                                    'Selesai' => 'SELESAI',
                                    'cancelled' => 'DIBATALKAN'
                                ];

                                $displayStatus = $statusMap[$order->status] ?? strtoupper($order->status);
                                $isUnpaid = in_array($order->status, ['unpaid', 'pending', 'Belum Dibayar', 'pending_quote']);
                            @endphp

                            @if($isUnpaid)
                                <span class="badge rounded-pill bg-dark text-danger border border-danger px-3 py-2 small">
                                    {{ $displayStatus }}
                                </span>
                            @elseif($order->status == 'Menunggu Verifikasi')
                                <span class="badge rounded-pill bg-primary px-3 py-2 small">
                                    {{ $displayStatus }}
                                </span>
                            @elseif(in_array($order->status, ['completed', 'Selesai']))
                                <span class="badge rounded-pill bg-success px-3 py-2 small">
                                    {{ $displayStatus }}
                                </span>
                            @else
                                <span class="badge rounded-pill bg-secondary px-3 py-2 small">
                                    {{ $displayStatus }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-dark btn-sm border-secondary text-white-50" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($isUnpaid)
                                    <form action="{{ route('member.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm border-secondary text-danger"
                                                onclick="return confirm('Batalkan pesanan ini?')" title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                    @if($order->status != 'pending_quote')
                                    <a href="{{ route('member.orders.payment', $order->id) }}" class="btn btn-warning btn-sm fw-bold text-dark px-3 shadow-sm">
                                        BAYAR
                                    </a>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-box-open fa-3x mb-3 text-secondary" style="opacity: 0.3;"></i>
                            <h6 class="text-white-50">Belum ada riwayat pesanan.</h6>
                            <a href="{{ route('member.products.index') }}" class="btn btn-outline-warning btn-sm mt-2">Mulai Belanja</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if($orders->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {!! $orders->links() !!}
    </div>
    @endif
</div>
@endsection
