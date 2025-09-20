@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@section('content')
    <div class="container-fluid">
        <h1 class="h2 pt-3 pb-2 mb-3 border-bottom border-secondary">Pengaturan</h1>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab">Profil Admin</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="store-tab" data-bs-toggle="tab" data-bs-target="#store" type="button"
                            role="tab">Pengaturan Toko</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="settingsTabsContent">
                    {{-- Tab Profil Admin --}}
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <h5>Profil Admin</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </form>
                    </div>
                    {{-- Tab Pengaturan Toko --}}
                    <div class="tab-pane fade" id="store" role="tabpanel">
                        <h5>Pengaturan Toko</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Nama Toko</label>
                                <input type="text" class="form-control" value="KESTORE.ID">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control"
                                    rows="3">Jl. Kenangan No. 123, Kota Bandung, Jawa Barat</textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Pengaturan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
