@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4 class="mb-0"><i class=""></i> Daftar Akun Baru</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required
                                    autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope"></i> Email Address
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email Anda"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock"></i> Password
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan password (minimal 8 karakter)"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    Password minimal 8 karakter
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="bi bi-lock-fill"></i> Konfirmasi Password
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password Anda" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan <a href="#" class="text-decoration-none">syarat dan ketentuan</a>
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-2">Sudah punya akun?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-success">
                                <i class="bi bi-box-arrow-in-right"></i> Login di Sini
                            </a>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                atau <a href="{{ url('/') }}" class="text-decoration-none">kembali ke beranda</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');

            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Password tidak sama');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            password.addEventListener('change', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);
        });
    </script>
@endsection