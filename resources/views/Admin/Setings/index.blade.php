@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
        <h1 class="h2 text-white">Pengaturan</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold me-2" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab">
                        <i class="fas fa-user-shield me-2"></i> Profil Admin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold me-2" id="pills-store-tab" data-bs-toggle="pill" data-bs-target="#pills-store" type="button" role="tab">
                        <i class="fas fa-store me-2"></i> Informasi Toko
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="pills-payment-tab" data-bs-toggle="pill" data-bs-target="#pills-payment" type="button" role="tab">
                        <i class="fas fa-money-bill-wave me-2"></i> Pembayaran
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel">
                    <div class="card border-secondary" style="background-color: #1a1a1a;">
                        <div class="card-header border-secondary text-warning fw-bold">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil & Keamanan
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label text-white-50">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                           class="form-control bg-dark text-white border-secondary" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-white-50">Alamat Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                           class="form-control bg-dark text-white border-secondary" required>
                                </div>

                                <h6 class="text-warning mb-3 border-bottom border-secondary pb-2">Ubah Password (Opsional)</h6>

                                <div class="mb-3">
                                    <label class="form-label text-white-50">Password Baru</label>
                                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary"
                                           placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-white-50">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary">
                                </div>

                                <button type="submit" class="btn btn-warning fw-bold w-100">
                                    <i class="fas fa-save me-2"></i> Simpan Profil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-store" role="tabpanel">
                    <div class="card border-secondary" style="background-color: #1a1a1a;">
                        <div class="card-header border-secondary text-warning fw-bold">
                            <i class="fas fa-store-alt me-2"></i> Pengaturan Toko
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.store.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label text-white-50">Nama Toko</label>
                                    <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'Kestore.id' }}"
                                           class="form-control bg-dark text-white border-secondary" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-white-50">Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '' }}"
                                           class="form-control bg-dark text-white border-secondary" placeholder="08xxxxxxxx">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-white-50">Alamat Toko</label>
                                    <textarea name="store_address" rows="3"
                                              class="form-control bg-dark text-white border-secondary">{{ $settings['store_address'] ?? '' }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-warning fw-bold w-100">
                                    <i class="fas fa-save me-2"></i> Simpan Informasi Toko
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-payment" role="tabpanel">
                    <div class="card border-secondary" style="background-color: #1a1a1a;">
                        <div class="card-header border-secondary text-warning fw-bold">
                            <i class="fas fa-money-bill-wave me-2"></i> Rekening Transfer Manual
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="alert alert-dark border-secondary text-white-50 d-flex align-items-center mb-4">
                                    <i class="fas fa-info-circle text-warning me-3 fa-2x"></i>
                                    <div>
                                        <strong class="text-white">Informasi Pembayaran Manual</strong><br>
                                        Data rekening di bawah ini akan ditampilkan kepada pembeli pada halaman <b>Checkout</b> dan <b>Detail Pesanan</b>.
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-white-50">Nama Bank / E-Wallet</label>
                                        <select name="payment_bank_name" class="form-select bg-dark text-white border-secondary">
                                            <option value="" disabled selected>-- Pilih Bank --</option>
                                            @foreach(['BCA', 'BRI', 'MANDIRI', 'BNI', 'BSI', 'DANA', 'GOPAY', 'SHOPEEPAY', 'OVO'] as $bank)
                                                <option value="{{ $bank }}" {{ ($settings['payment_bank_name'] ?? '') == $bank ? 'selected' : '' }}>
                                                    {{ $bank }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-white-50">Nomor Rekening</label>
                                        <input type="number" name="payment_account_number" value="{{ $settings['payment_account_number'] ?? '' }}"
                                               class="form-control bg-dark text-white border-secondary"
                                               placeholder="Contoh: 1234567890" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-white-50">Atas Nama (Pemilik Rekening)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-secondary">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="payment_account_holder" value="{{ $settings['payment_account_holder'] ?? '' }}"
                                               class="form-control bg-dark text-white border-secondary"
                                               placeholder="Contoh: Kestore Official / Nama Pribadi" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning fw-bold w-100 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan Rekening
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Ubah warna tab aktif menjadi Emas */
    .nav-pills .nav-link.active {
        background-color: #ffc107 !important;
        color: #000 !important;
    }
    /* Ubah warna tab tidak aktif menjadi Putih */
    .nav-pills .nav-link {
        color: #fff;
        background-color: transparent;
        border: 1px solid #333;
    }
    .nav-pills .nav-link:hover {
        border-color: #ffc107;
        color: #ffc107;
    }
</style>
@endpush

@endsection
