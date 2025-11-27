@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-grid-fill"></i> Daftar Lapangan
                </h2>
                <p class="text-muted mb-0">Kelola dan lihat semua lapangan futsal</p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('lapangan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Lapangan
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @forelse($lapangans as $lapangan)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        @if($lapangan->foto)
                            <img src="{{ Storage::url($lapangan->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                 style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-stadium" style="font-size: 4rem; color: white;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0">{{ $lapangan->nama }}</h5>
                                <span class="badge bg-{{ $lapangan->status == 'Tersedia' ? 'success' : 'warning' }}">
                                    {{ $lapangan->status }}
                                </span>
                            </div>
                            
                            
                            @if($lapangan->totalReviews > 0)
                                <div class="mb-2">
                                    <a href="{{ route('reviews.lapangan', $lapangan->id) }}" class="text-decoration-none">
                                        {!! $lapangan->starsHtml !!}
                                        <small class="text-muted">
                                            ({{ number_format($lapangan->averageRating, 1) }}) 
                                            • {{ $lapangan->totalReviews }} review
                                        </small>
                                    </a>
                                </div>
                            @endif
                            
                            <p class="text-muted mb-2">
                                <i class="bi bi-tag"></i> {{ $lapangan->jenis }}
                            </p>
                            
                            <h4 class="text-primary fw-bold mb-3">
                                Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                                <small class="text-muted fs-6">/jam</small>
                            </h4>

                            @if($lapangan->deskripsi)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($lapangan->deskripsi, 80) }}
                                </p>
                            @endif

                            <div class="d-flex gap-2 mt-3">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('lapangan.edit', $lapangan) }}" class="btn btn-sm btn-warning flex-fill">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('lapangan.destroy', $lapangan) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('booking.create') }}?lapangan={{ $lapangan->id }}" 
                                       class="btn btn-primary flex-fill {{ $lapangan->status != 'Tersedia' ? 'disabled' : '' }}">
                                        <i class="bi bi-calendar-plus"></i> Booking Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada lapangan yang tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection