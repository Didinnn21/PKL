@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
            <h1 class="h2">Edit Produk: {{ $product->name }}</h1>
        </div>

        <div class="card" style="background-color: #2c2c2c; border: 1px solid #444;">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="{{ old('name', $product->name) }}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="price" name="price" required
                                value="{{ old('price', $product->price) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" required
                                value="{{ old('stock', $product->stock) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">URL Gambar (Opsional)</label>
                        <input type="text" class="form-control" id="image_url" name="image_url"
                            value="{{ old('image_url', $product->image_url) }}">
                    </div>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">Update Produk</button>
                </form>
            </div>
        </div>
    </div>
@endsection
