@extends('layouts.member')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold text-white mb-0">Profil Akun</h2>
            <a href="{{ route('profile.edit') }}" class="btn btn-warning fw-bold text-dark btn-sm">
                <i class="fas fa-edit me-2"></i> Edit Profil
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-secondary" style="background-color: #141414; color: #ffffff;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-4 position-relative d-inline-block">
                            <div class="rounded-circle d-flex align-items-center justify-content-center border border-warning mx-auto"
                                style="width: 110px; height: 110px; background-color: #000; box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);">
                                <i class="fas fa-user fa-4x text-warning"></i>
                            </div>
                        </div>

                        <h3 class="text-white fw-bold mb-1">{{ Auth::user()->name }}</h3>
                        <span class="badge bg-warning text-dark mb-4 px-3">MEMBER KESTORE</span>

                        <hr class="border-secondary my-4">

                        <div class="row text-start mt-4">
                            <div class="col-md-6 mb-4">
                                <label class="small text-white text-uppercase fw-bold mb-1 opacity-75">Email</label>
                                <div class="text-white fs-5 border-bottom border-dark pb-2">
                                    <i class="fas fa-envelope me-2 text-warning small"></i> {{ Auth::user()->email }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="small text-white text-uppercase fw-bold mb-1 opacity-75">Nomor Telepon</label>
                                <div class="text-white fs-5 border-bottom border-dark pb-2">
                                    <i class="fas fa-phone me-2 text-warning small"></i>
                                    {{ Auth::user()->phone ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="small text-white text-uppercase fw-bold mb-1 opacity-75">Tanggal Lahir</label>
                                <div class="text-white fs-5 border-bottom border-dark pb-2">
                                    <i class="fas fa-calendar-alt me-2 text-warning small"></i>
                                    {{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="small text-white text-uppercase fw-bold mb-1 opacity-75">Bergabung
                                    Sejak</label>
                                <div class="text-white fs-5 border-bottom border-dark pb-2">
                                    <i class="fas fa-clock me-2 text-warning small"></i>
                                    {{ Auth::user()->created_at->format('d F Y') }}
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="small text-white text-uppercase fw-bold mb-1 opacity-75">Alamat
                                    Lengkap</label>
                                <div class="text-white fs-5 p-3 rounded border border-secondary"
                                    style="background-color: #0a0a0a;">
                                    <i class="fas fa-map-marker-alt me-2 text-warning small"></i>
                                    {{ Auth::user()->address ?? 'Alamat belum diisi.' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection