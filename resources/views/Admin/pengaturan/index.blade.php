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
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab"
                            data-bs-target="#profile" type="button" role="tab">Profil Admin</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab"
                            data-bs-target="#store" type="button" role="tab">Pengaturan Toko</button></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="settingsTabsContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <h5>Profil Admin</h5>
                        <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')
                            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', Auth::user()->name) }}" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', Auth::user()->email) }}" required></div>
                            <hr class="border-secondary my-4">
                            <p class="text-muted">Isi hanya jika Anda ingin mengubah password.</p>
                            <div class="mb-3"><label class="form-label">Password Baru</label><input type="password"
                                    name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input
                                    type="password" name="password_confirmation" class="form-control"></div>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="store" role="tabpanel">
                        <h5>Pengaturan Toko</h5>
                        <form class="mt-3">
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
