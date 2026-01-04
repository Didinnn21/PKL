@extends('layouts.dashboard')

@section('title', 'Edit Jasa Kirim')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
            <h1 class="h2 text-white">Edit Jasa Kirim</h1>
            <a href="{{ route('admin.shippings.index') }}" class="btn btn-outline-secondary text-white btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-secondary" style="background-color: #1a1a1a;">
                    <div class="card-header border-secondary text-warning fw-bold">
                        <i class="fas fa-edit me-2"></i> Perbarui Informasi Layanan
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.shippings.update', $shipping->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-white">Nama Layanan</label>
                                <input type="text" name="name" value="{{ $shipping->name }}"
                                    class="form-control bg-dark text-white border-secondary" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Tarif (Rp)</label>
                                <input type="number" name="price" value="{{ $shipping->price }}"
                                    class="form-control bg-dark text-white border-secondary" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-white">Estimasi Waktu</label>
                                <input type="text" name="etd" value="{{ $shipping->etd }}"
                                    class="form-control bg-dark text-white border-secondary">
                            </div>

                            <button type="submit" class="btn btn-warning w-100 fw-bold">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
