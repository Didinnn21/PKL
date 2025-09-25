@extends('layouts.app')

@section('styles')
    <style>
        .auth-container {
            display: flex;
            min-height: calc(100vh - 56px);
            /* Full height minus navbar */
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            display: flex;
            width: 100%;
            max-width: 900px;
            background-color: #252525;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #444;
        }

        .auth-form-section {
            flex: 1;
            padding: 40px;
        }

        .auth-visual-section {
            flex: 1;
            background-image: url('{{ asset('images/Slide-3.png') }}');
            background-size: cover;
            background-position: center;
            display: none;
            /* Sembunyikan di mobile */
        }

        .auth-header h2 {
            font-weight: 700;
            color: #fff;
        }

        .auth-header p {
            color: #ccc;
        }

        .form-control {
            height: 50px;
            padding: 0 15px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
        }

        .or-separator {
            display: flex;
            align-items: center;
            text-align: center;
            color: #888;
            margin: 20px 0;
        }

        .or-separator::before,
        .or-separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #555;
        }

        .or-separator:not(:empty)::before {
            margin-right: .25em;
        }

        .or-separator:not(:empty)::after {
            margin-left: .25em;
        }

        @media (min-width: 768px) {
            .auth-visual-section {
                display: block;
                /* Tampilkan di desktop */
            }
        }
    </style>
@endsection

@section('content')
    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-form-section">
                <div class="auth-header mb-4">
                    <h2>Selamat Datang Kembali!</h2>
                    <p>Masuk untuk melanjutkan ke Kestore.id</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
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

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input id="password" type="password" placeholder="Masukkan password Anda"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                style="border-color: #555;">
                                <i class="fas fa-eye" style="color: #ccc;"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Ingat Saya') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="or-separator">atau</div>

                    <div class="text-center">
                        <p class="mb-0 text-muted">Belum punya akun? <a href="{{ route('register') }}"
                                class="btn-link">Daftar di sini</a></p>
                    </div>
                </form>
            </div>
            <div class="auth-visual-section">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const icon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endsection
