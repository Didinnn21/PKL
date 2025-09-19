@extends('layouts.dashboard')

@section('title', 'Kelola Produk')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
            <h1 class="h2">Kelola Produk</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Produk Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card" style="background-color: #2c2c2c; border: 1px solid #444;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover" style="background-color: #2c2c2c;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }} unit</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada produk yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
