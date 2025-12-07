@extends('layouts.member')

@section('title', 'Pesan Custom')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold text-white mb-0">Buat Pesanan Custom</h2>
            <a href="{{ route('member.dashboard') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-body p-5">

                        {{-- Alert Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger text-white border-0"
                                style="background-color: rgba(239, 68, 68, 0.2);">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('custom.order') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label text-white">Judul Pesanan / Nama Produk</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Contoh: Hoodie Angkatan 2024" required>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label text-white">Jumlah</label>
                                    <input type="number" id="quantity" name="quantity" min="1" class="form-control"
                                        placeholder="1" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="image" class="form-label text-white">Unggah Desain (JPG/PNG)</label>
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label text-white">Deskripsi Detail</label>
                                <textarea id="description" name="description" rows="5" class="form-control"
                                    placeholder="Jelaskan detail warna, ukuran, bahan, dan posisi sablon..."
                                    required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning fw-bold py-3 text-dark">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Pesanan Custom
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection