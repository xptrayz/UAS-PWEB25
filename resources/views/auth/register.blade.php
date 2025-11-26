@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                        <h2 class="mt-3 fw-bold">Buat Akun Member</h2>
                        <p class="text-muted">Daftar untuk mulai booking lapangan futsal</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-person"></i> Nama Lengkap
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="contoh@email.com">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-phone"></i> No. Telepon
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone') }}"
                                   placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password"
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-lock-fill"></i> Konfirmasi Password
                            </label>
                            <input type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="Ulangi password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Daftar Sekarang
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection