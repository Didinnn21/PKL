@extends('layouts.app')

@section('styles')
    <style>
        .auth-container {
            display: flex;
            min-height: calc(100vh - 56px);
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
            background-image: url('{{ asset('images/Slide-2.png') }}');
            background-size: cover;
            background-position: center;
            display: none;
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
                    <p>Mulai perjalanan gayamu bersama Kestore.id</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Nama Lengkap') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="Masukkan alamat email">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" placeholder="Minimal 8 karakter">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                style="border-color: #555;"><i class="fas fa-eye" style="color: #ccc;"></i></button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Ulangi password Anda">
                    </div>

                    <div class="d-grid mb-3 mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="btn-link">Login
                                di sini</a></p>
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
