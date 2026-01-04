@extends('layouts.dashboard')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
        <h1 class="h2 text-white">Detail Pesanan</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary text-white btn-sm hover-warning">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-secondary mb-4" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary text-warning fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-shopping-bag me-2"></i> ID Pesanan: #{{ $order->id }}</span>
                    <span class="badge bg-secondary text-white border border-secondary">
                        {{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless align-middle mb-0">
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr style="border-bottom: 1px solid #333;">
                                        <td style="width: 80px;" class="py-3">
                                            <img src="{{ $item->product->image_url ?: 'https://placehold.co/80x80/2c2c2c/FFFFFF/png?text=IMG' }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="rounded border border-secondary"
                                                 style="width: 70px; height: 70px; object-fit: cover;">
                                        </td>

                                        <td class="py-3">
                                            <h6 class="text-white fw-bold mb-1">{{ $item->product->name }}</h6>
                                            <div class="text-white-50 small mb-1">
                                                Jumlah: <span class="text-white">{{ $item->quantity }} pcs</span>
                                            </div>
                                            @if($order->notes)
                                                <div class="text-warning small fst-italic">
                                                    <i class="fas fa-sticky-note me-1"></i> Catatan: "{{ $order->notes }}"
                                                </div>
                                            @endif
                                        </td>

                                        <td class="text-end py-3">
                                            <div class="text-white-50 small">Harga Satuan</div>
                                            <div class="text-white">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 pt-3">
                        @php
                            // 1. Ambil dari kolom shipping_cost jika ada
                            $ongkir = $order->shipping_cost ?? 0;

                            // 2. Jika 0, coba ambil angka dari teks jasa kirim "JNE... (Rp 25.000)"
                            if ($ongkir == 0 && $order->shipping_service) {
                                // Regex cari angka setelah Rp
                                preg_match('/Rp\s*([0-9\.]+)/', $order->shipping_service, $matches);
                                if (isset($matches[1])) {
                                    // Hapus titik, jadikan integer
                                    $ongkir = (int) str_replace('.', '', $matches[1]);
                                }
                            }

                            // 3. Hitung Subtotal agar matematika pas
                            $subtotal = $order->total_price - $ongkir;
                        @endphp

                        {{-- Subtotal --}}
                        <div class="d-flex justify-content-between text-white-50 mb-2">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        {{-- Ongkir --}}
                        <div class="d-flex justify-content-between text-white-50 mb-2">
                            <span>Jasa Pengiriman ({{ $order->shipping_service ?? 'Kurir' }})</span>
                            <span class="text-white">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>

                        <div class="border-top border-secondary my-2"></div>

                        {{-- Total Grand --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-white h5 mb-0">Total Pembayaran</span>
                            <span class="text-warning h3 mb-0 fw-bold">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-secondary h-100" style="background-color: #1a1a1a;">
                        <div class="card-header border-secondary text-warning fw-bold">
                            <i class="fas fa-map-marker-alt me-2"></i> Alamat Pengiriman
                        </div>
                        <div class="card-body text-white">
                            <p class="mb-0" style="line-height: 1.6;">
                                {{ $order->shipping_address ?? $order->user->address ?? 'Alamat tidak tersedia' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-secondary h-100" style="background-color: #1a1a1a;">
                        <div class="card-header border-secondary text-warning fw-bold">
                            <i class="fas fa-receipt me-2"></i> Bukti Pembayaran
                        </div>
                        <div class="card-body text-center d-flex align-items-center justify-content-center">
                            @if($order->payment_proof)
                                {{-- Jika ada bukti --}}
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                         class="img-fluid rounded border border-secondary shadow-sm"
                                         style="max-height: 200px;"
                                         alt="Bukti Bayar">
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-2 border-secondary">
                                        <i class="fas fa-expand"></i>
                                    </a>
                                </div>
                            @else
                                {{-- Jika belum ada --}}
                                <div class="text-white-50 py-3">
                                    <div class="mb-3">
                                        <i class="fas fa-image fa-3x opacity-25"></i>
                                    </div>
                                    <p class="mb-2">Belum ada bukti pembayaran.</p>
                                    <span class="badge bg-danger">Belum Dibayar</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="card border-secondary mb-4" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary text-warning fw-bold">
                    <i class="fas fa-edit me-2"></i> Perbarui Status
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-white-50 small mb-1">Status Saat Ini:</label>
                            <div class="d-block">
                                @php
                                    $statusColor = 'secondary';
                                    if($order->status == 'Menunggu Pembayaran') $statusColor = 'warning text-dark';
                                    elseif($order->status == 'Menunggu Verifikasi') $statusColor = 'info text-dark';
                                    elseif($order->status == 'Diproses') $statusColor = 'primary';
                                    elseif($order->status == 'Dikirim') $statusColor = 'info';
                                    elseif($order->status == 'Selesai') $statusColor = 'success';
                                    elseif($order->status == 'Dibatalkan') $statusColor = 'danger';
                                @endphp
                                <span class="badge bg-{{ $statusColor }} px-3 py-2 rounded-pill fs-6">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label text-white">Ubah Menjadi:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary text-secondary">
                                    <i class="fas fa-tasks"></i>
                                </span>
                                <select name="status" id="status" class="form-select bg-dark text-white border-secondary">
                                    <option value="Menunggu Pembayaran" {{ $order->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="Menunggu Verifikasi" {{ $order->status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Dikirim" {{ $order->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-secondary mb-4" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary text-warning fw-bold">
                    <i class="fas fa-user-circle me-2"></i> Informasi Pembeli
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-dark border border-secondary d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user text-warning fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-0 fw-bold">{{ $order->user->name ?? 'Tamu' }}</h6>
                            <small class="badge bg-secondary text-white-50" style="font-size: 0.65rem;">PELANGGAN</small>
                        </div>
                    </div>

                    <div class="border-top border-secondary pt-3">
                        <div class="mb-2">
                            <small class="text-white-50 d-block">Email:</small>
                            <span class="text-white"><i class="fas fa-envelope me-2 text-warning"></i> {{ $order->user->email ?? '-' }}</span>
                        </div>
                        <div>
                            <small class="text-white-50 d-block">Telepon:</small>
                            <span class="text-white"><i class="fas fa-phone me-2 text-warning"></i> {{ $order->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-warning:hover {
        border-color: #ffc107 !important;
        color: #ffc107 !important;
    }
    .form-select:focus {
        background-color: #2c2c2c;
        color: #fff;
        border-color: #d4af37;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }
</style>
@endpush
@endsection
