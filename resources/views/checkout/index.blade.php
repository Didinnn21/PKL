@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
    <style>
        /* Card Styling */
        .checkout-card {
            background-color: #141414;
            /* Abu Sangat Gelap */
            border: 1px solid #333;
            border-radius: 12px;
            padding: 2rem;
            color: #ffffff;
        }

        .summary-card {
            background-color: #0a0a0a;
            /* Hitam Pekat */
            border: 1px solid #333;
            border-radius: 12px;
            padding: 1.5rem;
            color: #ffffff;
        }

        /* --- FORM STYLING (WARNA PUTIH) --- */
        .form-label {
            color: #ffffff !important;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            background-color: #1f1f1f !important;
            border: 1px solid #444 !important;
            color: #ffffff !important;
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #1f1f1f !important;
            border-color: #d4af37 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
        }

        .form-control::placeholder {
            color: #888 !important;
            opacity: 1;
        }

        option {
            background-color: #1f1f1f;
            color: #ffffff;
        }

        hr {
            border-color: #444 !important;
            opacity: 1;
        }

        /* Teks Info Khusus */
        .info-text {
            font-size: 0.85rem;
            color: #a0a0a0;
            margin-top: 0.5rem;
            line-height: 1.4;
        }

        .info-warning {
            color: #f0c674;
        }

        /* Kuning Pucat */
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <h1 class="text-white text-3xl font-bold mb-4 fw-bold">Checkout Pesanan</h1>

        @if ($cartItems->isEmpty())
            <div class="checkout-card text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-white fs-4">Keranjang belanja Anda kosong.</p>
                <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold mt-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali Belanja
                </a>
            </div>
        @else
            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="checkout-card shadow-lg">
                            <h4 class="text-white mb-4 fw-bold border-bottom border-secondary pb-3">
                                <i class="fas fa-truck me-2 text-warning"></i> Informasi Pengiriman
                            </h4>

                            <div class="mb-4">
                                <label for="shipping_address" class="form-label">Alamat Lengkap</label>
                                <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required
                                    placeholder="Jalan, No. Rumah, RT/RW, Kecamatan, Kota, Kode Pos..."></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="shipping_service" class="form-label">Pilih Jasa Pengiriman</label>
                                <select name="shipping_service" id="shipping_service" class="form-select" required>
                                    <option value="" data-price="0">-- Pilih Ekspedisi --</option>
                                    @foreach($shippingOptions as $shipping)
                                        <option value="{{ $shipping->name }}" data-price="{{ $shipping->price }}">
                                            {{ $shipping->name }} - Rp {{ number_format($shipping->price, 0, ',', '.') }}
                                            ({{ $shipping->etd ?? 'Estd' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label">Catatan Pesanan (Opsional)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="2"
                                    placeholder="Contoh: Packing yang aman ya min..."></textarea>
                            </div>

                            <div class="mb-3 p-3 rounded border border-secondary" style="background-color: #1a1a1a;">
                                <label for="design_file" class="form-label fw-bold text-warning">
                                    <i class="fas fa-palette me-1"></i> Upload File Desain (Opsional)
                                </label>
                                <input class="form-control" type="file" id="design_file" name="design_file"
                                    accept="image/*,.cdr,.ai,.psd,.pdf">

                                <div class="info-text info-warning mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong>PENTING:</strong> Hanya upload jika Anda ingin menambah sablon/desain pada produk
                                    ini. Kosongkan jika membeli produk polos.
                                </div>
                                <div class="info-text">
                                    Format: JPG, PNG, PDF, CDR, AI. Maksimal ukuran file: 5MB.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="summary-card shadow-lg sticky-top" style="top: 100px;">
                            <h4 class="text-white mb-4 fw-bold border-bottom border-secondary pb-3">
                                <i class="fas fa-file-invoice-dollar me-2 text-warning"></i> Ringkasan
                            </h4>

                            @php
                                $subtotal = 0;
                                foreach ($cartItems as $item) {
                                    $subtotal += $item->product->price * $item->quantity;
                                }
                            @endphp

                            <div class="mb-3">
                                @foreach($cartItems as $item)
                                    <div class="d-flex justify-content-between mb-2 text-white small">
                                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                        <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal Produk</span>
                                <strong class="text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Ongkos Kirim</span>
                                <strong class="text-white" id="shipping-cost-text">Rp 0</strong>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="text-white fw-bold mb-0">Total Bayar</h5>
                                <h4 class="text-warning fw-bold mb-0" id="total-payment-text">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </h4>
                            </div>

                            <button type="submit"
                                class="btn btn-warning w-100 mt-4 py-3 fw-bold text-dark fs-5 shadow-sm hover-shadow">
                                <i class="fas fa-check-circle me-2"></i> Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const shippingSelect = document.getElementById('shipping_service');
                const shippingCostText = document.getElementById('shipping-cost-text');
                const totalPaymentText = document.getElementById('total-payment-text');
                const subtotal = {{ $subtotal ?? 0 }};

                shippingSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const shippingCost = parseInt(selectedOption.getAttribute('data-price')) || 0;
                    const totalPayment = subtotal + shippingCost;

                    const formatRupiah = (num) => 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                    shippingCostText.textContent = formatRupiah(shippingCost);
                    totalPaymentText.textContent = formatRupiah(totalPayment);
                });
            });
        </script>
    @endpush
@endsection
