@extends('layouts.dashboard')

@section('title', 'Kelola Pelanggan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
        <h1 class="h2 text-white">Kelola Pelanggan</h1>
        {{-- Tombol Tambah (Opsional, biasanya pelanggan daftar sendiri) --}}
        {{-- <a href="{{ route('admin.customers.create') }}" class="btn btn-warning fw-bold text-dark btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Baru
        </a> --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-secondary" style="background-color: #1a1a1a;">
        <div class="card-header border-secondary text-warning fw-bold">
            <i class="fas fa-users me-2"></i> Daftar Pelanggan Terdaftar
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0" style="background-color: #1a1a1a;">
                    <thead>
                        <tr style="border-bottom: 1px solid #444;">
                            <th class="text-warning ps-4 py-3" style="width: 5%;">No</th>
                            <th class="text-warning py-3">Nama</th>
                            <th class="text-warning py-3">Email</th>
                            <th class="text-warning py-3">Bergabung</th>
                            <th class="text-warning text-end pe-4 py-3" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr style="border-bottom: 1px solid #333;">
                                <td class="ps-4 py-3 align-middle text-white-50">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-3 align-middle">
                                    <span class="fw-bold text-white">{{ $customer->name }}</span>
                                </td>

                                <td class="py-3 align-middle">
                                    <span class="text-white">{{ $customer->email }}</span>
                                </td>

                                <td class="py-3 align-middle text-white-50">
                                    {{ $customer->created_at->translatedFormat('d M Y') }}
                                </td>

                                <td class="text-end pe-4 py-3 align-middle">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin hapus pelanggan ini? Semua data pesanan terkait juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-white-50">
                                    <i class="fas fa-user-slash fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data pelanggan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($customers, 'links'))
            <div class="card-footer border-secondary bg-transparent">
                <div class="d-flex justify-content-end">
                    {{ $customers->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
