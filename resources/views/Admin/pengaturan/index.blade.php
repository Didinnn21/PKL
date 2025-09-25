@extends('layouts.dashboard')
@section('title', 'Pengaturan')

@push('styles')
    <style>
        .settings-container {
            display: flex;
            gap: 2rem;
        }

        .settings-nav {
            flex: 0 0 200px;
        }

        .settings-nav .nav-link {
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
        }

        .settings-nav .nav-link.active {
            color: var(--primary-gold);
            border-left-color: var(--primary-gold);
            background-color: var(--dark-surface-2);
            font-weight: 600;
        }

        .settings-nav .nav-link:hover:not(.active) {
            color: #fff;
        }

        .settings-content {
            flex: 1;
        }

        .card-settings {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
        }

        .form-text {
            color: var(--text-muted);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 page-header">
            <h1 class="h2">Pengaturan</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="background-color: rgba(40, 167, 69, 0.2); border-color: #28a745; color:#28a745;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                style="background-color: rgba(220, 53, 69, 0.2); border-color: #dc3545; color:#dc3545;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                type="button" role="tab">Profil Admin</button>
            <button class="nav-link" id="v-pills-store-tab" data-bs-toggle="pill" data-bs-target="#v-pills-store"
                type="button" role="tab">Informasi Toko</button>
            <button class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payment"
                type="button" role="tab">Pembayaran</button>
        </div>

        <div class="tab-content mt-4" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel">
                <div class="card card-settings">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Profil Admin</h4>
                        <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name"
                                    class="form-control" value="{{ old('name', Auth::user()->name) }}" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                                    class="form-control" value="{{ old('email', Auth::user()->email) }}" required></div>
                            <hr class="my-4">
                            <p class="text-muted">Isi hanya jika Anda ingin mengubah password.</p>
                            <div class="mb-3"><label class="form-label">Password Baru</label><input type="password"
                                    name="password" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input
                                    type="password" name="password_confirmation" class="form-control"></div>
                            <button type="submit" class="btn btn-warning">Simpan Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="v-pills-store" role="tabpanel">
                <form action="{{ route('admin.settings.store.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card card-settings">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Informasi Toko</h4>
                            <div class="mb-3"><label class="form-label">Nama Toko</label><input type="text"
                                    name="store_name" class="form-control"
                                    value="{{ old('store_name', $settings['store_name'] ?? '') }}"></div>
                            <div class="mb-3"><label class="form-label">Tagline Toko</label><input type="text"
                                    name="store_tagline" class="form-control"
                                    value="{{ old('store_tagline', $settings['store_tagline'] ?? '') }}"
                                    placeholder="Contoh: Your Style, Indescribable"></div>
                            <div class="mb-3"><label class="form-label">Alamat</label><textarea name="store_address"
                                    class="form-control"
                                    rows="3">{{ old('store_address', $settings['store_address'] ?? '') }}</textarea></div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">No. Telepon (WA)</label><input
                                        type="text" name="store_phone" class="form-control"
                                        value="{{ old('store_phone', $settings['store_phone'] ?? '') }}"></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Email Toko</label><input type="email"
                                        name="store_email" class="form-control"
                                        value="{{ old('store_email', $settings['store_email'] ?? '') }}"></div>
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Informasi Toko</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="v-pills-payment" role="tabpanel">
                <form action="{{ route('admin.settings.store.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card card-settings">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Pengaturan Pembayaran</h4>
                            <div class="mb-3">
                                <label class="form-label">Informasi Pembayaran (Transfer Bank)</label>
                                <textarea name="payment_info" class="form-control" rows="5"
                                    placeholder="Contoh:&#10;BCA: 1234567890 a/n Kestore ID&#10;Mandiri: 0987654321 a/n Kestore ID">{{ old('payment_info', $settings['payment_info'] ?? '') }}</textarea>
                                <div class="form-text">Informasi ini akan ditampilkan kepada pelanggan saat checkout.</div>
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Pengaturan Pembayaran</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
