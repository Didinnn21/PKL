@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@push('styles')
    <style>
        .cart-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
        }

        .cart-item-row {
            border-bottom: 1px solid var(--dark-border);
        }

        .cart-item-row:last-child {
            border-bottom: none;
        }

        .product-image-cart {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .quantity-input {
            width: 70px;
            background-color: var(--dark-surface);
            color: var(--text-light);
            border-color: var(--dark-border);
        }

        .summary-card {
            background-color: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            padding: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <h1 class="text-white text-3xl font-bold mb-4">Keranjang Belanja Anda</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="cart-card p-5 text-center">
                <p class="text-muted fs-4">Keranjang Anda masih kosong.</p>
                <a href="{{ route('member.products.index') }}" class="btn btn-warning mt-3">Mulai Belanja</a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-card">
                        <div class="card-body p-4">
                            @php $subtotal = 0; @endphp
                            @foreach ($cartItems as $item)
                                <div class="row align-items-center py-3 cart-item-row">
                                    <div class="col-md-2">
                                        <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}"
                                            class="product-image-cart">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="mb-0 text-white">{{ $item->product->name }}</h5>
                                        <small class="text-muted">Harga: Rp {{ number_format($item->product->price) }}</small>
                                    </div>
                                    <div class="col-md-3">
                                        <form action="{{ route('member.cart.update', $item->id) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                max="{{ $item->product->stock }}"
                                                class="form-control form-control-sm quantity-input text-center">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">Update</button>
                                        </form>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <strong class="text-white">Rp
                                            {{ number_format($item->product->price * $item->quantity) }}</strong>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <form action="{{ route('member.cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">&times;</button>
                                        </form>
                                    </div>
                                </div>
                                @php $subtotal += $item->product->price * $item->quantity; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4 class="text-white mb-3">Ringkasan Belanja</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <strong class="text-white">Rp {{ number_format($subtotal) }}</strong>
                        </div>
                        <hr style="border-color: var(--dark-border);">
                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="text-white">Total</h5>
                            <h5 class="text-warning">Rp {{ number_format($subtotal) }}</h5>
                        </div>
                        <a href="{{ route('member.checkout.index') }}" class="btn btn-warning w-100 mt-4">
                            Lanjutkan ke Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
