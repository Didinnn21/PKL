@extends('layouts.member')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold text-white mb-0">Edit Profil</h2>
        <a href="{{ route('profile.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-secondary" style="background-color: #141414;">
                <div class="card-body p-5">
                    
                    @if(session('success'))
                        <div class="alert alert-success bg-success bg-opacity-25 text-white border-0 mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label text-white fw-bold">Nama Lengkap</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control bg-dark text-white border-secondary py-2" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label text-white fw-bold">Email</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control bg-dark text-white border-secondary py-2" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label text-white fw-bold">Nomor Telepon (WhatsApp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-warning border-secondary"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="phone" id="phone" 
                                           class="form-control bg-dark text-white border-secondary py-2" 
                                           value="{{ old('phone', Auth::user()->phone) }}" 
                                           placeholder="08123456789">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="birth_date" class="form-label text-white fw-bold">Tanggal Lahir</label>
                                <input type="date" name="birth_date" id="birth_date" 
                                       class="form-control bg-dark text-white border-secondary py-2" 
                                       value="{{ old('birth_date', Auth::user()->birth_date) }}">
                            </div>

                            <div class="col-12 mb-4">
                                <label for="address" class="form-label text-white fw-bold">Alamat Lengkap</label>
                                <textarea name="address" id="address" rows="4" 
                                          class="form-control bg-dark text-white border-secondary" 
                                          placeholder="Masukkan alamat lengkap pengiriman...">{{ old('address', Auth::user()->address) }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-warning fw-bold text-dark py-3">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection