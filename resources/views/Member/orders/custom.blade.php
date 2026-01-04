@extends('layouts.member')

@section('title', 'Pesan Produk Custom')

@section('content')
<div class="container-fluid pt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-white fw-bold"><i class="fas fa-layer-group text-warning me-2"></i> Pesanan Custom (Grosir/Satuan)</h4>
            <p class="text-white-50">Isi detail jumlah per ukuran dan unggah desain Anda di bawah ini.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <form action="{{ route('member.custom.order') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    {{-- KOLOM KIRI: SPESIFIKASI & UKURAN --}}
                    <div class="col-lg-7">
                        <div class="card border-secondary h-100" style="background-color: #1a1a1a; border-radius: 20px;">
                            <div class="card-body p-4">
                                <h5 class="text-warning fw-bold mb-4">1. Detail Produk & Ukuran</h5>

                                <div class="mb-4">
                                    <label class="form-label text-white-50">Jenis Produk</label>
                                    <select name="product_type" class="form-select bg-dark text-white border-secondary shadow-none" required>
                                        <option value="Kaos" selected>Kaos Custom</option>
                                        <option value="Hoodie">Hoodie Custom</option>
                                        <option value="Crewneck">Crewneck Custom</option>
                                    </select>
                                </div>

                                {{-- BAGIAN INPUT DINAMIS UKURAN --}}
                                <div class="mb-3">
                                    <label class="form-label text-white-50 d-flex justify-content-between">
                                        Rincian Ukuran
                                        <button type="button" class="btn btn-warning btn-sm fw-bold py-0" onclick="tambahBarisSize()">+ Tambah Ukuran</button>
                                    </label>
                                    <div id="size-container">
                                        <div class="row g-2 mb-2 size-row">
                                            <div class="col-7">
                                                <select name="sizes[]" class="form-select bg-dark text-white border-secondary" required>
                                                    <option value="S">Ukuran S</option>
                                                    <option value="M">Ukuran M</option>
                                                    <option value="L">Ukuran L</option>
                                                    <option value="XL">Ukuran XL</option>
                                                    <option value="XXL">Ukuran XXL</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="number" name="quantities[]" class="form-control bg-dark text-white border-secondary" placeholder="Jml" min="1" required>
                                            </div>
                                            <div class="col-1">
                                                <button type="button" class="btn btn-outline-danger btn-sm w-100 h-100" onclick="hapusBaris(this)"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label text-white-50">Instruksi Tambahan (Warna Kaos, Posisi Sablon, dll)</label>
                                    <textarea name="notes" rows="4" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Kaos warna Navy, Sablon depan A3, belakang Logo kecil di tengkuk..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DESAIN & SUBMIT --}}
                    <div class="col-lg-5">
                        <div class="card border-secondary h-100" style="background-color: #1a1a1a; border-radius: 20px;">
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="text-warning fw-bold mb-4">2. File Desain</h5>

                                <div class="upload-area mb-4 flex-grow-1 d-flex flex-column justify-content-center align-items-center border-secondary rounded p-4" style="background-color: #000; border: 2px dashed #333;">
                                    <i class="fas fa-file-upload fa-3x text-secondary mb-3"></i>
                                    <input type="file" name="design_file" class="form-control bg-dark text-white border-secondary mb-2" required>
                                    <p class="small text-white-50 text-center mb-0">Format JPG, PNG, atau PDF (Maks. 5MB)</p>
                                </div>

                                <div class="alert alert-dark border-secondary text-white-50 small mb-4">
                                    <i class="fas fa-info-circle text-warning me-2"></i>
                                    Admin akan menghitung total biaya berdasarkan rincian ukuran dan kerumitan desain Anda. Cek berkala menu <b>Riwayat Pesanan</b> untuk melihat penawaran harga.
                                </div>

                                <button type="submit" class="btn btn-warning fw-bold py-3 text-dark w-100 shadow">
                                    KIRIM PENGAJUAN CUSTOM <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function tambahBarisSize() {
        const container = document.getElementById('size-container');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-2 size-row';
        newRow.innerHTML = `
            <div class="col-7">
                <select name="sizes[]" class="form-select bg-dark text-white border-secondary" required>
                    <option value="S">Ukuran S</option>
                    <option value="M">Ukuran M</option>
                    <option value="L">Ukuran L</option>
                    <option value="XL">Ukuran XL</option>
                    <option value="XXL">Ukuran XXL</option>
                </select>
            </div>
            <div class="col-4">
                <input type="number" name="quantities[]" class="form-control bg-dark text-white border-secondary" placeholder="Jml" min="1" required>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-outline-danger btn-sm w-100 h-100" onclick="hapusBaris(this)"><i class="fas fa-times"></i></button>
            </div>
        `;
        container.appendChild(newRow);
    }

    function hapusBaris(btn) {
        const row = btn.closest('.size-row');
        if (document.querySelectorAll('.size-row').length > 1) {
            row.remove();
        } else {
            alert("Minimal harus ada satu rincian ukuran.");
        }
    }
</script>
@endsection
