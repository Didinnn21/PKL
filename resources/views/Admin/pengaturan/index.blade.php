@extends('layouts.dashboard')
@section('title', 'Pengaturan')
@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Pengaturan</h1>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" id="profile-tab"
                            data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profil Admin</button>
                    </li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="store-tab" data-bs-toggle="tab"
                            data-bs-target="#store" type="button" role="tab">Pengaturan Toko</button></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="settingsTabsContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <h5>Profil Admin</h5>
                        <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name"
                                    class="form-control" value="{{ old('name', Auth::user()->name) }}" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                                    class="form-control" value="{{ old('email', Auth::user()->email) }}" required></div>
                            <hr class="border-secondary">
                            <p class="text-muted">Isi hanya jika Anda ingin mengubah password.</p>
                            <div class="mb-3"><label class="form-label">Password Baru</label><input type="password"
                                    name="password" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input
                                    type="password" name="password_confirmation" class="form-control"></div>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="store" role="tabpanel">
                        <h5>Pengaturan Toko</h5>
                        <form>
                            <div class="mb-3"><label class="form-label">Nama Toko</label><input type="text"
                                    class="form-control" value="Kestore.id" disabled></div>
                            <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control"
                                    rows="3" disabled>Jl. Kenangan No. 123, Kota Bandung, Jawa Barat</textarea></div>
                            <button type="submit" class="btn btn-warning" disabled>Simpan Pengaturan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
