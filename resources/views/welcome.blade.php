<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Futsal Booking - Sistem Booking Lapangan Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
        }
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 80px 20px 50px;
        }
        .hero-content {
            text-align: center;
            color: white;
            z-index: 2;
        }
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
        }
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.95;
            animation: fadeInUp 1.2s ease;
        }
        .btn-custom {
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            margin: 10px;
            transition: all 0.3s ease;
            animation: fadeInUp 1.4s ease;
        }
        .btn-primary-custom {
            background: #10b981;
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            background: #059669;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }
        .btn-outline-custom {
            background: transparent;
            border: 2px solid white;
            color: white;
        }
        .btn-outline-custom:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }
        .features-section {
            background: white;
            padding: 80px 20px;
        }
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border: none;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 3rem;
            color: #10b981;
            margin-bottom: 20px;
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }
        .shape-1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        .shape-2 {
            top: 60%;
            right: 10%;
            animation-delay: 5s;
        }
        .shape-3 {
            bottom: 10%;
            left: 50%;
            animation-delay: 10s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-50px) rotate(180deg); }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: #10b981; font-size: 1.5rem;">
                <i class="bi bi-trophy"></i> Futsal Booking
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success px-4 ms-2" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white px-4 ms-2" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    
    <section class="hero-section">
        <div class="floating-shapes">
            <i class="bi bi-trophy shape shape-1" style="font-size: 150px;"></i>
            <i class="bi bi-calendar-check shape shape-2" style="font-size: 120px;"></i>
            <i class="bi bi-stadium shape shape-3" style="font-size: 180px;"></i>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="bi bi-trophy"></i> Futsal Booking
            </h1>
            <p class="hero-subtitle">
                Sistem Booking Lapangan Futsal Modern & Mudah
            </p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-primary-custom btn-custom">
                    <i class="bi bi-rocket-takeoff"></i> Mulai Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-custom btn-custom">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
        </div>
    </section>

    
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="text-center fw-bold mb-5" style="font-size: 3rem;">Fitur Unggulan</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-calendar-check feature-icon"></i>
                        <h4 class="fw-bold mb-3">Booking Mudah</h4>
                        <p class="text-muted">Pesan lapangan favorit Anda dengan mudah dalam hitungan detik</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-clock-history feature-icon"></i>
                        <h4 class="fw-bold mb-3">Real-Time</h4>
                        <p class="text-muted">Lihat ketersediaan lapangan secara real-time dan langsung booking</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-shield-check feature-icon"></i>
                        <h4 class="fw-bold mb-3">Aman & Terpercaya</h4>
                        <p class="text-muted">Sistem pembayaran yang aman dengan konfirmasi otomatis</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-grid feature-icon"></i>
                        <h4 class="fw-bold mb-3">Banyak Pilihan</h4>
                        <p class="text-muted">Berbagai jenis lapangan: Sintetis, Vinyl, dan Rumput Asli</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-phone feature-icon"></i>
                        <h4 class="fw-bold mb-3">Responsive</h4>
                        <p class="text-muted">Akses dari mana saja, kapan saja melalui HP, tablet, atau laptop</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-graph-up feature-icon"></i>
                        <h4 class="fw-bold mb-3">Manajemen Lengkap</h4>
                        <p class="text-muted">Pantau riwayat booking dan status pembayaran dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="hero-section" style="min-height: 60vh;">
        <div class="hero-content">
            <h2 class="mb-4" style="font-size: 2.5rem;">Siap Untuk Bermain?</h2>
            <p class="mb-4" style="font-size: 1.2rem;">Daftar sekarang dan dapatkan pengalaman booking lapangan yang lebih mudah!</p>
            <a href="{{ route('register') }}" class="btn btn-primary-custom btn-custom">
                <i class="bi bi-rocket-takeoff"></i> Daftar Gratis
            </a>
        </div>
    </section>

    
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">© 2025 Futsal Booking. All rights reserved.</p>
            <p class="mb-0 mt-2">
                <i class="bi bi-trophy"></i> By Adjastya Budi Adjie S
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>