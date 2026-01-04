@extends('layouts.dashboard')

@section('title', 'Kelola Jasa Kirim')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
        <h1 class="h2 text-white">Kelola Jasa Kirim</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-secondary" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary text-warning fw-bold">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Jasa Kirim
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.shippings.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-50">Nama Layanan</label>
                            <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                                   placeholder="Contoh: JNE REG" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50">Tarif (Rp)</label>
                            <input type="number" name="price" class="form-control bg-dark text-white border-secondary"
                                   placeholder="15000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50">Estimasi (Opsional)</label>
                            <input type="text" name="etd" class="form-control bg-dark text-white border-secondary"
                                   placeholder="Contoh: 2-3 Hari">
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">
                            <i class="fas fa-save me-1"></i> Simpan Layanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-secondary" style="background-color: #1a1a1a;">
                <div class="card-header border-secondary text-warning fw-bold">
                    <i class="fas fa-truck me-2"></i> Daftar Jasa Kirim
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0" style="background-color: #1a1a1a;">
                            <thead>
                                <tr style="border-bottom: 1px solid #444;">
                                    <th class="text-warning ps-4 py-3">Nama Layanan</th>
                                    <th class="text-warning py-3">Tarif</th>
                                    <th class="text-warning py-3">Estimasi</th>
                                    <th class="text-warning text-end pe-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shippings as $shipping)
                                    <tr style="border-bottom: 1px solid #333;">
                                        <td class="ps-4 py-3 align-middle fw-bold text-white">
                                            {{ $shipping->name }}
                                        </td>
                                        <td class="py-3 align-middle text-warning">
                                            Rp {{ number_format($shipping->price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 align-middle text-white-50">
                                            <i class="fas fa-clock me-1 text-secondary"></i> {{ $shipping->etd ?? '-' }}
                                        </td>

                                        <td class="text-end pe-4 py-3 align-middle">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.shippings.edit', $shipping->id) }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.shippings.destroy', $shipping->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Hapus jasa kirim ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-white-50">
                                            Belum ada jasa kirim.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
