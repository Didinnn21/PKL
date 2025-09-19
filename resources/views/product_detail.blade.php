@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Detail Produk') }}</div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset($product->image_url ?? 'https://placehold.co/600x600/252525/FFFFFF/png?text=Gambar+Produk') }}"
                                    class="img-fluid rounded" alt="{{ $product->name }}">
                            </div>
                            <div class="col-md-6">
                                <h2>{{ $product->name }}</h2>
                                <p class="text-muted">{{ $product->description }}</p>
                                <h3 class="my-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                                <p><strong>Stok:</strong> {{ $product->stock }} unit</p>

                                <hr class="border-secondary">

                                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                            min="1" max="{{ $product->stock }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="design_file" class="form-label">
                                            Upload Desain Anda <span class="text-muted">(Opsional)</span>
                                        </label>
                                        <input class="form-control" type="file" id="design_file" name="design_file"
                                            accept="image/*,.cdr,.ai,.psd">
                                        <div class="form-text text-muted">Format yang didukung: JPG, PNG, CDR, AI, PSD.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Catatan Tambahan</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                            placeholder="Contoh: Ukuran L, sablon di bagian depan saja."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
