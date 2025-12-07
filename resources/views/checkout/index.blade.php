@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
    <style>
        .checkout-card {
            background-color: var(--dark-surface-2);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            padding: 2rem;
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
    <h1 class="text-white text-3xl font-bold mb-4">Checkout</h1>
    @if ($cartItems->isEmpty())
        <div class="checkout-card text-center">
            <p class="text-muted fs-4">Anda tidak memiliki item untuk di-checkout.</p>
            <a href="{{ route('member.products.index') }}" class="btn btn-warning mt-3">Kembali ke Katalog</a>
        </div>
    @else
        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="checkout-card">
                        <h4 class="text-white mb-4">Detail Pengiriman & Pesanan</h4>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Alamat Pengiriman Lengkap</label>
                            <textarea name="shipping_address" id="shipping_address" class="form-control" rows="4" required placeholder="Contoh: Jl. Kemerdekaan No. 17, RT 01 RW 02, Kelurahan..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_service" class="form-label">Pilih Jasa Pengiriman</label>
                            <select name="shipping_service" id="shipping_service" class="form-select" required>
                                <option value="">-- Pilih Ekspedisi --</option>
                                @foreach($shippingOptions as $service => $price)
                                    <option value="{{ $service }}">{{ $service }} - Rp {{ number_format($price) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Contoh: Ukuran L, sablon di bagian depan saja."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="design_file" class="form-label">Upload Desain (Opsional)</label>
                            <input class="form-control" type="file" id="design_file" name="design_file" accept="image/*,.cdr,.ai,.psd">
                             <div class="form-text text-muted">Format: JPG, PNG, CDR, AI, PSD. (Maks: 3MB)</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="summary-card">
                        <h4 class="text-white mb-3">Ringkasan Pesanan</h4>
                        @php
                            $subtotal = 0;
                            foreach($cartItems as $item) {
                                $subtotal += $item->product->price * $item->quantity;
                            }
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                            <strong class="text-white">Rp {{ number_format($subtotal) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Ongkos Kirim</span>
                            <strong class="text-white" id="shipping-cost-text">Rp 0</strong>
                        </div>
                        <hr style="border-color: var(--dark-border);">
                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="text-white">Total Pembayaran</h5>
                            <h5 class="text-warning" id="total-payment-text">Rp {{ number_format($subtotal) }}</h5>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 mt-4">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingSelect = document.getElementById('shipping_service');
        const shippingCostText = document.getElementById('shipping-cost-text');
        const totalPaymentText = document.getElementById('total-payment-text');
        const subtotal = {{ $subtotal }};
        const shippingOptions = @json($shippingOptions);

        shippingSelect.addEventListener('change', function() {
            const selectedService = this.value;
            const shippingCost = shippingOptions[selectedService] || 0;
            const totalPayment = subtotal + shippingCost;

            shippingCostText.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
            totalPaymentText.textContent = 'Rp ' + totalPayment.toLocaleString('id-ID');
        });
    });
</script>
@endpush
@endsection
