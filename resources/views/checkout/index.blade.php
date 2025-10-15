@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Checkout</h2>
        {{-- Tampilkan ringkasan belanja dari $cartItems --}}

        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            {{-- Loop through cartItems to create hidden inputs for products --}}
            @foreach($cartItems as $item)
                <input type="hidden" name="products[{{ $item->product_id }}][quantity]" value="{{ $item->quantity }}">
            @endforeach


            <div class="mb-3">
                <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                <textarea name="shipping_address" id="shipping_address" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="shipping_service" class="form-label">Jasa Pengiriman</label>
                <select name="shipping_service" id="shipping_service" class="form-control">
                    @foreach($shippingOptions as $service => $price)
                        <option value="{{ $service }}">{{ $service }} - Rp {{ number_format($price) }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </form>
    </div>
@endsection
