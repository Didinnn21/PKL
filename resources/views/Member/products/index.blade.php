@extends('layouts.member')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Katalog Produk</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Produk</li>
        </ol>

        <div class="row">
            @forelse($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('product.detail', $product->id) }}">
                            <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a>
                            </h4>
                            <h5>Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 75) }}</p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary w-100">Lihat Detail &
                                Pesan</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Tidak ada produk yang tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection
