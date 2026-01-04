@extends('layouts.member')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="text-white fw-bold">Keranjang Saya</h4>
                <p class="text-white-50">Tinjau kembali pilihan produk Anda sebelum melakukan pembayaran.</p>
            </div>
        </div>

        @if($cartItems->isEmpty())
            <div class="card border-secondary text-center p-5" style="background-color: #1a1a1a;">
                <div class="card-body">
                    <i class="fas fa-shopping-cart fa-4x text-secondary mb-3"></i>
                    <h5 class="text-white">Keranjang Anda Kosong</h5>
                    <p class="text-white-50">Sepertinya Anda belum memilih produk favorit Anda.</p>
                    <a href="{{ route('member.products.index') }}" class="btn btn-warning fw-bold mt-3 text-dark">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-secondary mb-4" style="background-color: #1a1a1a;">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle" style="background-color: #1a1a1a;">
                                <thead class="text-warning">
                                    <tr>
                                        <th class="ps-4 py-3">Produk</th>
                                        <th>Ukuran</th>
                                        <th style="width: 150px;">Jumlah</th>
                                        <th>Subtotal</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr class="border-secondary">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($item->product->image_url ?? 'https://placehold.co/50x50/1a1a1a/d4af37?text=P') }}"
                                                        class="rounded border border-secondary me-3"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0 text-white fw-bold">{{ $item->product->name }}</h6>
                                                        <small class="text-warning">Rp
                                                            {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-dark border border-warning text-warning fw-bold px-3">
                                                    {{ $item->size }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('member.cart.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="quantity"
                                                            class="form-control bg-dark text-white border-secondary text-center"
                                                            value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                            onchange="this.form.submit()">
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-white fw-bold">
                                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center pe-4">
                                                <form action="{{ route('member.cart.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0"
                                                        onclick="return confirm('Hapus produk ini?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- RINGKASAN BELANJA --}}
                <div class="col-lg-4">
                    <div class="card border-warning shadow" style="background-color: #000; border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="text-warning fw-bold mb-4"><i class="fas fa-receipt me-2"></i> Ringkasan Belanja</h5>

                            <div class="d-flex justify-content-between text-white-50 mb-2">
                                <span>Total Item</span>
                                <span>{{ $cartItems->sum('quantity') }} Pcs</span>
                            </div>

                            <hr class="border-secondary">

                            <div class="d-flex justify-content-between text-white mb-4">
                                <span class="fw-bold">Total Harga</span>
                                <span class="fw-bold text-warning" style="font-size: 1.4rem;">
                                    Rp
                                    {{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.') }}
                                </span>
                            </div>

                            <a href="{{ route('member.checkout.index') }}" class="btn btn-warning w-100 fw-bold py-3 text-dark">
                                LANJUT KE PEMBAYARAN <i class="fas fa-arrow-right ms-2"></i>
                            </a>

                            <a href="{{ route('member.products.index') }}"
                                class="btn btn-outline-light w-100 btn-sm mt-3 border-secondary">
                                <i class="fas fa-plus me-2"></i> Tambah Produk Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
