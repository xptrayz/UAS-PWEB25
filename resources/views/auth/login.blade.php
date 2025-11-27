@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                        <h2 class="mt-3 fw-bold">Selamat Datang!</h2>
                        <p class="text-muted">Login untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="contoh@email.com">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="Masukkan password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Demo Akun
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-info-circle"></i> Demo Akun
                    </h6>
                    <small class="text-muted">
                        <strong>Admin:</strong> admin@futsal.com / password<br>
                        <strong>Member:</strong> member@futsal.com / password
                    </small>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection