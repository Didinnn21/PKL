@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Keranjang Belanja Anda</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($cartItems->isEmpty())
            <p>Keranjang Anda kosong.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>Rp {{ number_format($item->product->price) }}</td>
                            <td>Rp {{ number_format($item->product->price * $item->quantity) }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-success">Lanjutkan ke Pembayaran</a>
        @endif
    </div>
@endsection
