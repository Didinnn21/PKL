@extends('layouts.dashboard')

@section('title', 'Kelola Jasa Kirim')

@section('content')
    <div class="container-fluid p-0">
        <h2 class="h4 fw-bold text-white mb-4">Kelola Jasa Kirim</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-secondary" style="background-color: #141414;">
                    <div class="card-header border-secondary text-white fw-bold">Tambah Jasa Kirim</div>
                    <div class="card-body">
                        <form action="{{ route('admin.shippings.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-white">Nama Layanan</label>
                                <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                                    placeholder="Contoh: JNE REG" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white">Tarif (Rp)</label>
                                <input type="number" name="price" class="form-control bg-dark text-white border-secondary"
                                    placeholder="15000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white">Estimasi (Opsional)</label>
                                <input type="text" name="etd" class="form-control bg-dark text-white border-secondary"
                                    placeholder="2-3 Hari">
                            </div>
                            <button type="submit" class="btn btn-warning fw-bold w-100 text-dark">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-secondary" style="background-color: #141414;">
                    <div class="card-header border-secondary text-white fw-bold">Daftar Jasa Kirim</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0" style="color: #fff;">
                            <thead class="bg-black text-warning">
                                <tr>
                                    <th class="ps-4">Nama Layanan</th>
                                    <th>Tarif</th>
                                    <th>Estimasi</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shippings as $ship)
                                    <tr style="border-bottom: 1px solid #333;">
                                        <td class="ps-4">{{ $ship->name }}</td>
                                        <td class="fw-bold text-warning">Rp {{ number_format($ship->price, 0, ',', '.') }}</td>
                                        <td>{{ $ship->etd ?? '-' }}</td>
                                        <td class="text-end pe-4">
                                            <form action="{{ route('admin.shippings.destroy', $ship->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus jasa kirim ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data jasa kirim.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection