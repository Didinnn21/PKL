@extends('layouts.dashboard')

@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
            <h1 class="h2">Tambah Produk Baru</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}"
                            placeholder="Contoh: Kestore Hoodie Basic">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required
                            placeholder="Jelaskan detail produk, bahan, ukuran, dll.">{{ old('description') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="price" name="price" required
                                value="{{ old('price') }}" placeholder="Contoh: 250000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" required
                                value="{{ old('stock') }}" placeholder="Contoh: 150">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">URL Gambar (Opsional)</label>
                        <input type="text" class="form-control" id="image_url" name="image_url"
                            value="{{ old('image_url') }}" placeholder="https://example.com/gambar.jpg">
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-warning">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
