@extends('layouts.member')

@section('title', 'Katalog Produk')

@section('content')
<div class="container-fluid pt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-white fw-bold">Katalog Produk</h4>
            <p class="text-white-50">Temukan koleksi eksklusif dari Kestore.id dan pilih ukuran yang sesuai.</p>
        </div>
    </div>

    {{-- BARIS PRODUK --}}
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-secondary shadow-sm" style="background-color: #1a1a1a; border-radius: 15px; overflow: hidden;">
                <div class="position-relative bg-black d-flex align-items-center justify-content-center" style="height: 200px; padding: 15px;">
                    <img src="{{ asset($product->image_url ?? 'https://placehold.co/300x300/1a1a1a/d4af37?text=Produk') }}"
                         class="img-fluid" alt="{{ $product->name }}" style="max-height: 100%; object-fit: contain;">
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 fw-bold">
                        Stok: {{ $product->stock }}
                    </span>
                </div>

                <div class="card-body d-flex flex-column p-3">
                    <h6 class="text-white fw-bold mb-1">{{ $product->name }}</h6>
                    <p class="text-warning fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-white-50 small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.8rem;">
                        {{ $product->description }}
                    </p>

                    {{-- FORM TERPADU --}}
                    {{-- Kita menggunakan form ID unik agar JavaScript (jika ada) atau tombol submit tidak bentrok --}}
                    <form action="{{ route('member.cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">

                        <div class="mb-3">
                            <label class="text-white-50 small mb-1 d-block">Pilih Ukuran:</label>
                            <select name="size" class="form-select form-select-sm bg-dark text-white border-secondary shadow-none" required>
                                <option value="" selected disabled>-- Pilih Ukuran --</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-warning btn-sm fw-bold">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>

                            <div class="row g-2">
                                <div class="col-6">
                                    {{-- Tombol Submit ke Keranjang --}}
                                    <button type="submit" class="btn btn-dark btn-sm border-secondary w-100 fw-bold text-white shadow-sm">
                                        <i class="fas fa-cart-plus"></i> +Keranjang
                                    </button>
                                </div>
                                <div class="col-6">
                                    {{-- Tombol Beli Sekarang (Menimpa action form menggunakan formaction) --}}
                                    <button type="submit" formaction="{{ route('member.checkout.direct') }}" class="btn btn-warning btn-sm w-100 fw-bold text-dark shadow-sm">
                                        Beli Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
