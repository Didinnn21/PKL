@extends('layouts.app')

@section('styles')
    <style>
        /* Container Utama */
        .auth-container {
            display: flex;
            min-height: calc(100vh - 80px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Kartu Auth */
        .auth-card {
            display: flex;
            width: 100%;
            max-width: 900px;
            background-color: #0a0a0a; /* Hitam Pekat */
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #333;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }

        .auth-card:hover {
            border-color: #d4af37;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.15);
        }

        /* Bagian Form (Kiri) */
        .auth-form-section {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Bagian Gambar (Kanan) */
        .auth-visual-section {
            flex: 1;
            background-image: url('{{ asset('images/Slide-3.png') }}');
            background-size: cover;
            background-position: center;
            position: relative;
            display: none;
        }

        .auth-visual-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to right, #0a0a0a, transparent, rgba(0,0,0,0.4));
        }

        /* Typography (Semua Putih) */
        .auth-header h2 {
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .auth-header p {
            color: #ffffff;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .form-label {
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Input Fields */
        .form-control {
            background-color: #141414;
            border: 1px solid #333;
            color: #ffffff;
            height: 50px;
            padding: 0 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: #141414;
            border-color: #d4af37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.2);
            color: #ffffff;
        }

        .form-control::placeholder {
            color: #bbbbbb;
        }

        /* Toggle Password Button */
        .btn-toggle-password {
            background-color: #141414;
            border: 1px solid #333;
            border-left: none;
            color: #ffffff;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .btn-toggle-password:hover {
            background-color: #1f1f1f;
            color: #d4af37;
            border-color: #333;
        }

        .input-group .form-control {
            border-right: none;
        }

        /* Separator */
        .or-separator {
            display: flex;
            align-items: center;
            text-align: center;
            color: #ffffff;
            margin: 25px 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        .or-separator::before,
        .or-separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #444;
        }

        .or-separator:not(:empty)::before { margin-right: 1em; }
        .or-separator:not(:empty)::after { margin-left: 1em; }

        /* Links */
        .btn-link-gold {
            color: #d4af37;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .btn-link-gold:hover {
            color: #f1c40f;
            text-decoration: underline;
        }

        /* Button Primary (Emas, Teks Hitam) */
        .btn-primary {
            background-color: #d4af37;
            border: none;
            color: #000000;
            font-weight: 800;
            padding: 12px;
            border-radius: 8px;
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #f1c40f;
            transform: translateY(-2px);
            color: #000000;
        }

        @media (min-width: 768px) {
            .auth-visual-section {
                display: block;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-form-section">
                <div class="auth-header mb-4">
                    <h2>Buat Akun Baru</h2>
                    <p>Lengkapi data diri untuk bergabung dengan Kestore.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Nama Lengkap') }}</label>
                        <input id="name" type="text" placeholder="Masukkan nama lengkap"
                            class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" placeholder="contoh@email.com"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input id="password" type="password" placeholder="Minimal 8 karakter"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            <button class="btn btn-toggle-password" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                        <div class="input-group">
                            <input id="password-confirm" type="password" placeholder="Ulangi password"
                                class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <button class="btn btn-toggle-password" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            {{ __('DAFTAR SEKARANG') }}
                        </button>
                    </div>

                    <div class="or-separator">sudah punya akun?</div>

                    <div class="text-center">
                        <p class="mb-0 text-white small opacity-75">Silakan Login
                            <a href="{{ route('login') }}" class="btn-link-gold ms-1">di sini</a>
                        </p>
                    </div>
                </form>
            </div>

            <div class="auth-visual-section"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Fungsi untuk mengaktifkan toggle password
            function setupPasswordToggle(buttonId, inputId) {
                const toggleBtn = document.querySelector(buttonId);
                const passwordInput = document.querySelector(inputId);

                if (!toggleBtn || !passwordInput) return; // Mencegah error jika elemen tidak ditemukan

                const icon = toggleBtn.querySelector('i');

                toggleBtn.addEventListener('click', function () {
                    // Toggle tipe input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icon
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');

                    // Toggle warna icon
                    if (type === 'text') {
                        toggleBtn.style.color = '#d4af37';
                    } else {
                        toggleBtn.style.color = '#ffffff';
                    }
                });
            }

            // Aktifkan untuk kolom Password
            setupPasswordToggle('#togglePassword', '#password');

            // Aktifkan untuk kolom Konfirmasi Password
            setupPasswordToggle('#toggleConfirmPassword', '#password-confirm');
        });
    </script>
@endsection
