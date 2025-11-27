@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">
                        <i class="bi bi-receipt"></i> Detail Booking #{{ $booking->id }}
                    </h2>
                    <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                
                <div class="text-center mb-4">
                    <span class="badge bg-{{ $booking->statusBadge }}" style="font-size: 1.2rem; padding: 12px 30px;">
                        {{ $booking->status }}
                    </span>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle"></i> Informasi Booking
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="bi bi-calendar"></i> Tanggal:</strong><br>
                                    <span class="fs-5">{{ $booking->tanggal_booking->format('d F Y') }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="bi bi-clock"></i> Jam:</strong><br>
                                    <span class="fs-5">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="bi bi-hourglass"></i> Durasi:</strong><br>
                                    <span class="fs-5">{{ $booking->durasi }} Jam</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="bi bi-calendar-plus"></i> Dibuat:</strong><br>
                                    <span class="fs-5">{{ $booking->created_at->format('d M Y, H:i') }}</span>
                                </p>
                            </div>
                        </div>

                        @if($booking->catatan)
                            <div class="alert alert-info">
                                <strong><i class="bi bi-sticky"></i> Catatan:</strong><br>
                                {{ $booking->catatan }}
                            </div>
                        @endif
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-stadium"></i> Informasi Lapangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            @if($booking->lapangan->foto)
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <img src="{{ Storage::url($booking->lapangan->foto) }}" 
                                         alt="{{ $booking->lapangan->nama }}" 
                                         class="img-fluid rounded">
                                </div>
                            @endif
                            
                            <div class="{{ $booking->lapangan->foto ? 'col-md-8' : 'col-12' }}">
                                <h4 class="fw-bold mb-2">{{ $booking->lapangan->nama }}</h4>
                                <p class="mb-2">
                                    <span class="badge bg-secondary">{{ $booking->lapangan->jenis }}</span>
                                    <span class="badge bg-{{ $booking->lapangan->status == 'Tersedia' ? 'success' : 'warning' }}">
                                        {{ $booking->lapangan->status }}
                                    </span>
                                </p>
                                
                                @if($booking->lapangan->deskripsi)
                                    <p class="text-muted mb-2">{{ $booking->lapangan->deskripsi }}</p>
                                @endif

                                <h5 class="text-primary fw-bold mb-0">
                                    Rp {{ number_format($booking->lapangan->harga_per_jam, 0, ',', '.') }}
                                    <small class="text-muted fs-6">/jam</small>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                
                @if(Auth::user()->isAdmin())
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person"></i> Informasi Member
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Nama:</strong> {{ $booking->user->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong> {{ $booking->user->email }}
                            </p>
                            @if($booking->user->phone)
                                <p class="mb-0">
                                    <strong>No. Telepon:</strong> {{ $booking->user->phone }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-cash-stack"></i> Ringkasan Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2"><strong>Harga per Jam:</strong></p>
                                <p class="mb-2"><strong>Durasi:</strong></p>
                                <hr>
                                <p class="mb-0"><strong>Total Pembayaran:</strong></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-2">Rp {{ number_format($booking->lapangan->harga_per_jam, 0, ',', '.') }}</p>
                                <p class="mb-2">{{ $booking->durasi }} Jam</p>
                                <hr>
                                <h4 class="text-primary mb-0 fw-bold">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                
                @if(Auth::user()->isAdmin())
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-gear"></i> Ubah Status Booking
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('booking.updateStatus', $booking) }}" method="POST">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-8 mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Pilih Status:</label>
                                        <select name="status" class="form-select" required>
                                            <option value="Menunggu Pembayaran" {{ $booking->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>
                                                Menunggu Pembayaran
                                            </option>
                                            <option value="Lunas" {{ $booking->status == 'Lunas' ? 'selected' : '' }}>
                                                Lunas
                                            </option>
                                            <option value="Selesai" {{ $booking->status == 'Selesai' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                            <option value="Dibatalkan" {{ $booking->status == 'Dibatalkan' ? 'selected' : '' }}>
                                                Dibatalkan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-save"></i> Update Status
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    
                    @if($booking->canBeReviewed())
                        <div class="alert alert-success">
                            <h5 class="alert-heading">
                                <i class="bi bi-star"></i> Booking Selesai
                            </h5>
                            <p class="mb-3">
                                Terima kasih telah menggunakan layanan kami! 
                                Bagaimana pengalaman Anda? Berikan review untuk lapangan ini.
                            </p>
                            <a href="{{ route('reviews.create', $booking->id) }}" class="btn btn-warning">
                                <i class="bi bi-star-fill"></i> Tulis Review
                            </a>
                        </div>
                    @elseif($booking->review)
                        <div class="alert alert-info">
                            <h5 class="alert-heading">
                                <i class="bi bi-check-circle"></i> Review Anda
                            </h5>
                            <div class="mb-2">
                                {!! $booking->review->starsHtml !!}
                            </div>
                            @if($booking->review->komentar)
                                <p class="mb-2">"{{ $booking->review->komentar }}"</p>
                            @endif
                            <small class="text-muted">
                                Ditulis {{ $booking->review->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <h5 class="alert-heading">
                                <i class="bi bi-info-circle"></i> Informasi Pembayaran
                            </h5>
                            @if($booking->status == 'Menunggu Pembayaran')
                                <p class="mb-0">
                                    Silakan lakukan pembayaran dan hubungi admin untuk konfirmasi. 
                                    Status booking Anda akan diupdate oleh admin setelah pembayaran dikonfirmasi.
                                </p>
                            @elseif($booking->status == 'Lunas')
                                <p class="mb-0">
                                    <i class="bi bi-check-circle"></i> Pembayaran Anda telah dikonfirmasi! 
                                    Silakan datang sesuai jadwal yang telah ditentukan.
                                </p>
                            @else
                                <p class="mb-0">
                                    <i class="bi bi-x-circle"></i> Booking ini telah dibatalkan.
                                </p>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection