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

        /* Kartu Login */
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
            border-color: #d4af37; /* Border emas saat hover */
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
            display: none; /* Hidden di Mobile */
        }

        .auth-visual-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to right, #0a0a0a, transparent, rgba(0,0,0,0.4));
        }

        /* --- TYPOGRAPHY (SEMUA PUTIH) --- */
        .auth-header h2 {
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .auth-header p {
            color: #ffffff; /* Ubah jadi Putih */
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .form-label {
            color: #ffffff; /* Ubah jadi Putih */
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Override Bootstrap text-muted agar jadi putih */
        .text-muted {
            color: #ffffff !important;
            opacity: 0.8;
        }

        /* --- INPUT FIELDS --- */
        .form-control {
            background-color: #141414;
            border: 1px solid #333;
            color: #ffffff; /* Teks input putih */
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
            color: #bbbbbb; /* Placeholder agak terang */
        }

        /* Tombol Toggle Password */
        .btn-toggle-password {
            background-color: #141414;
            border: 1px solid #333;
            border-left: none;
            color: #ffffff; /* Icon putih */
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

        /* Checkbox Custom */
        .form-check-input {
            background-color: #141414;
            border-color: #666;
        }

        .form-check-input:checked {
            background-color: #d4af37;
            border-color: #d4af37;
        }

        .form-check-label {
            color: #ffffff; /* Label checkbox putih */
        }

        /* Separator */
        .or-separator {
            display: flex;
            align-items: center;
            text-align: center;
            color: #ffffff; /* Teks separator putih */
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

        /* --- BUTTON PRIMARY (Warna Emas, Teks Hitam) --- */
        .btn-primary {
            background-color: #d4af37;
            border: none;
            color: #000000; /* TEKS TETAP HITAM */
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
                <div class="auth-header mb-5">
                    <h2>Selamat Datang</h2>
                    <p>Silakan masuk untuk mengelola akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" placeholder="contoh@email.com"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input id="password" type="password" placeholder="Masukkan password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="remember">
                                {{ __('Ingat Saya') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="small text-muted text-decoration-none hover-gold" href="{{ route('password.request') }}" style="transition: color 0.2s;">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('MASUK SEKARANG') }}
                        </button>
                    </div>

                    <div class="or-separator">atau</div>

                    <div class="text-center">
                        <p class="mb-0 text-muted small">Belum punya akun?
                            <a href="{{ route('register') }}" class="btn-link-gold ms-1">Register disini</a>
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
            const toggleBtn = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');
            const icon = toggleBtn.querySelector('i');

            toggleBtn.addEventListener('click', function () {
                // Toggle tipe input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');

                // Toggle warna icon agar user tau sedang aktif
                if (type === 'text') {
                    toggleBtn.style.color = '#d4af37';
                } else {
                    toggleBtn.style.color = '#ffffff';
                }
            });

            // Efek hover tambahan untuk link Lupa Password
            const forgotLink = document.querySelector('.hover-gold');
            if(forgotLink) {
                forgotLink.addEventListener('mouseenter', () => forgotLink.style.color = '#d4af37');
                forgotLink.addEventListener('mouseleave', () => forgotLink.style.color = '#ffffff');
            }
        });
    </script>
@endsection
