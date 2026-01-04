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
                        <th class="text-warning border-secondary">Detail Produk</th>
                        <th class="text-warning border-secondary text-center">Total Harga</th>
                        <th class="text-warning border-secondary text-center">Status</th>
                        {{-- POSISI TENGAH: text-center --}}
                        <th class="text-warning border-secondary text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-secondary">
                        <td class="ps-4 fw-bold text-white-50">#{{ $order->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @php $firstItem = $order->items->first(); @endphp
                                <img src="{{ asset($firstItem?->product?->image_url ?? 'https://placehold.co/50x50/1a1a1a/d4af37?text=P') }}"
                                     class="rounded border border-secondary me-3"
                                     style="width: 45px; height: 45px; object-fit: cover;">
                                <div>
                                    <div class="text-white fw-bold">{{ $firstItem?->product?->name ?? 'Produk Kustom' }}</div>
                                    <small class="text-white-50">{{ $order->items->sum('quantity') }} Pcs</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-warning fw-bold text-nowrap text-center">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @php
                                // Pemetaan Status ke Bahasa Indonesia
                                $statusMap = [
                                    'pending' => 'BELUM DIBAYAR',
                                    'Belum Dibayar' => 'BELUM DIBAYAR',
                                    'MENUNGGU PEMBAYARAN' => 'BELUM DIBAYAR',
                                    'Menunggu Pembayaran' => 'BELUM DIBAYAR',
                                    'Menunggu Verifikasi' => 'MENUNGGU VERIFIKASI',
                                    'processing' => 'DIPROSES',
                                    'completed' => 'SELESAI',
                                    'Selesai' => 'SELESAI',
                                    'cancelled' => 'DIBATALKAN'
                                ];

                                $displayStatus = $statusMap[$order->status] ?? strtoupper($order->status);

                                // Cek kondisi untuk tampilan tombol
                                $isPending = in_array($order->status, ['pending', 'Belum Dibayar', 'MENUNGGU PEMBAYARAN', 'Menunggu Pembayaran']);
                                $isVerifying = ($order->status == 'Menunggu Verifikasi');
                            @endphp

                            @if($isPending)
                                <span class="badge rounded-pill bg-dark text-danger border border-danger px-3 py-2">
                                    {{ $displayStatus }}
                                </span>
                            @elseif($isVerifying)
                                <span class="badge rounded-pill bg-primary px-3 py-2">
                                    {{ $displayStatus }}
                                </span>
                            @elseif($order->status == 'completed' || $order->status == 'Selesai')
                                <span class="badge rounded-pill bg-success px-3 py-2">
                                    {{ $displayStatus }}
                                </span>
                            @else
                                <span class="badge rounded-pill bg-secondary px-3 py-2">
                                    {{ $displayStatus }}
                                </span>
                            @endif
                        </td>
                        {{-- KOLOM AKSI: text-center & justify-content-center --}}
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-dark btn-sm border-secondary text-white-50" title="Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                {{-- Aksi Edit & Hapus & Bayar: Hanya muncul jika belum bayar --}}
                                @if($isPending)
                                    <a href="{{ route('member.orders.edit', $order->id) }}" class="btn btn-dark btn-sm border-secondary text-info" title="Ubah Alamat/Catatan">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('member.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm border-secondary text-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan #{{ $order->id }}?')" title="Batalkan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('member.orders.payment', $order->id) }}" class="btn btn-warning btn-sm fw-bold text-dark px-3 shadow-sm">
                                        Bayar
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-box-open fa-3x mb-3 text-secondary" style="opacity: 0.3;"></i>
                            <h6 class="text-white-50">Belum ada riwayat pesanan.</h6>
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
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
