@extends('layouts.dashboard')

@section('title', 'Kelola Produk')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
            <h1 class="h2 text-white">Kelola Produk</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-warning fw-bold text-dark btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-secondary" style="background-color: #1a1a1a;">
            <div class="card-header border-secondary text-warning fw-bold">
                <i class="fas fa-box me-2"></i> Daftar Produk Tersedia
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0" style="background-color: #1a1a1a;">
                        <thead>
                            <tr style="border-bottom: 1px solid #444;">
                                <th class="text-warning ps-4 py-3" style="width: 5%;">ID</th>
                                <th class="text-warning py-3" style="width: 15%;">Gambar</th>
                                <th class="text-warning py-3">Nama Produk</th>
                                <th class="text-warning py-3">Harga</th>
                                <th class="text-warning py-3">Stok</th>
                                <th class="text-warning text-end pe-4 py-3" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr style="border-bottom: 1px solid #333;">
                                    <td class="ps-4 py-3 align-middle text-white-50">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="py-3 align-middle">
                                        <img src="{{ $product->image_url ?: 'https://placehold.co/80x80/2c2c2c/FFFFFF/png?text=Produk' }}"
                                             alt="{{ $product->name }}"
                                             class="rounded border border-secondary"
                                             width="50" height="50"
                                             style="object-fit: cover;">
                                    </td>

                                    <td class="py-3 align-middle">
                                        <span class="fw-bold text-white d-block">{{ $product->name }}</span>
                                    </td>

                                    <td class="py-3 align-middle">
                                        <span class="fw-bold text-warning">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="py-3 align-middle">
                                        @if($product->stock > 0)
                                            <span class="badge bg-dark border border-secondary text-white">
                                                {{ $product->stock }} Unit
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white">Habis</span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-4 py-3 align-middle">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-white-50">
                                        <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada produk yang ditambahkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($products, 'links'))
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
