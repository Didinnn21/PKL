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
                                {{-- PERBAIKAN LOGIKA GAMBAR & NAMA --}}
                                @php
                                    if ($order->order_type === 'custom') {
                                        // Jika Custom: Ambil file desain yang diupload
                                        $imagePath = asset('storage/' . $order->design_file);
                                        $productName = 'Custom: ' . $order->product_type;
                                    } else {
                                        // Jika Regular: Ambil dari relasi produk
                                        $product = $order->product ?? ($order->orderItems->first() ? $order->orderItems->first()->product : null);
                                        $imagePath = ($product && $product->image)
                                            ? asset('storage/products/' . $product->image)
                                            : asset('images/Slide-2.png');
                                        $productName = $product ? $product->name : 'Produk Kestore';
                                    }
                                @endphp

                                <img src="{{ $imagePath }}"
                                     class="rounded border border-secondary me-3"
                                     style="width: 50px; height: 50px; object-fit: cover;"
                                     onerror="this.src='{{ asset('images/Slide-2.png') }}'">
                                <div>
                                    <div class="text-white fw-bold small text-uppercase">{{ $productName }}</div>
                                    <small class="text-white-50">
                                        {{ $order->quantity ?? ($order->orderItems->sum('quantity') ?: 1) }} Item
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="text-warning fw-bold text-nowrap text-center">
                            @if($order->total_price > 0)
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            @else
                                <span class="text-white-50 small fst-italic">Menunggu Harga</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                // Pemetaan Status ke Bahasa Indonesia (Admin & Member sinkron)
                                $statusMap = [
                                    'pending_quote' => 'MENUNGGU PENAWARAN',
                                    'Menunggu Penawaran' => 'MENUNGGU PENAWARAN',
                                    'unpaid' => 'MENUNGGU PEMBAYARAN',
                                    'Menunggu Pembayaran' => 'MENUNGGU PEMBAYARAN',
                                    'Menunggu Verifikasi' => 'PROSES VERIFIKASI',
                                    'Diproses' => 'SEDANG DIPROSES',
                                    'Dikirim' => 'DALAM PENGIRIMAN',
                                    'Selesai' => 'SELESAI',
                                    'Dibatalkan' => 'DIBATALKAN'
                                ];

                                $displayStatus = $statusMap[$order->status] ?? strtoupper($order->status);

                                // Penentuan Warna Badge
                                $badgeClass = 'bg-secondary';
                                if (in_array($order->status, ['pending_quote', 'Menunggu Penawaran', 'unpaid', 'Menunggu Pembayaran'])) {
                                    $badgeClass = 'bg-dark text-warning border border-warning';
                                } elseif ($order->status == 'Menunggu Verifikasi') {
                                    $badgeClass = 'bg-info text-dark';
                                } elseif ($order->status == 'Selesai') {
                                    $badgeClass = 'bg-success';
                                } elseif ($order->status == 'Dibatalkan') {
                                    $badgeClass = 'bg-danger';
                                }
                            @endphp

                            <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2 small">
                                {{ $displayStatus }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-dark btn-sm border-secondary text-white-50" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Tombol Aksi berdasarkan status --}}
                                @if(in_array($order->status, ['pending_quote', 'Menunggu Penawaran', 'Menunggu Pembayaran', 'unpaid']))
                                    <form action="{{ route('member.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm border-secondary text-danger"
                                                onclick="return confirm('Batalkan pesanan ini?')" title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                    {{-- Tombol Bayar hanya muncul jika harga sudah ditentukan dan bukan status penawaran --}}
                                    @if(!in_array($order->status, ['pending_quote', 'Menunggu Penawaran']) && $order->total_price > 0)
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
