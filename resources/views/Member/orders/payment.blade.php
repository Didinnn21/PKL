@extends('layouts.member')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold text-white mb-0">Konfirmasi Pembayaran</h2>
            <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-secondary" style="background-color: #141414;">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <p class="text-muted mb-1 text-uppercase small">Total Tagihan</p>
                            <h2 class="text-white fw-bold display-5">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</h2>
                            <span class="badge bg-warning text-dark mt-2">Order #{{ $order->id }}</span>
                        </div>

                        <hr class="border-secondary my-4">

                        <div class="bg-dark p-4 rounded border border-secondary mb-4">
                            <h6 class="text-white fw-bold mb-3">
                                <i class="fas fa-university me-2 text-warning"></i> Silakan Transfer ke:
                            </h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Bank / E-Wallet</span>
                                <span class="text-white fw-bold fs-5">
                                    {{ $settings['payment_bank_name'] ?? 'BCA' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Nomor Rekening</span>
                                <span class="text-white fw-bold fs-5">
                                    {{ $settings['payment_account_number'] ?? '123-456-7890' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Atas Nama</span>
                                <span class="text-white">
                                    {{ $settings['payment_account_holder'] ?? 'Kestore Official' }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('member.orders.update_payment', $order->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="payment_proof" class="form-label text-white fw-bold">Unggah Bukti
                                    Transfer</label>
                                <input type="file" name="payment_proof" id="payment_proof"
                                    class="form-control bg-dark text-white border-secondary" required>
                                <div class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB.</div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning fw-bold text-dark py-3">
                                    <i class="fas fa-upload me-2"></i> Kirim Bukti Pembayaran
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
