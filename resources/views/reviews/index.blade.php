@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold mb-2">
                    <i class="bi bi-star-fill text-warning"></i> Review Lapangan
                </h2>
                <h4 class="text-muted">{{ $lapangan->nama }}</h4>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center border-end">
                        <h1 class="display-3 fw-bold text-warning mb-0">
                            {{ number_format($lapangan->averageRating, 1) }}
                        </h1>
                        <div class="mb-2">
                            {!! $lapangan->starsHtml !!}
                        </div>
                        <p class="text-muted mb-0">{{ $lapangan->totalReviews }} Review</p>
                    </div>
                    <div class="col-md-9">
                        <h5 class="fw-bold mb-3">Distribusi Rating</h5>
                        @php
                            $totalReviews = $lapangan->totalReviews;
                            for ($i = 5; $i >= 1; $i--) {
                                $count = $lapangan->reviews->where('rating', $i)->count();
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                echo '<div class="row align-items-center mb-2">';
                                echo '<div class="col-2 text-end">' . $i . ' <i class="bi bi-star-fill text-warning"></i></div>';
                                echo '<div class="col-8">';
                                echo '<div class="progress" style="height: 20px;">';
                                echo '<div class="progress-bar bg-warning" style="width: ' . $percentage . '%"></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="col-2">' . $count . '</div>';
                                echo '</div>';
                            }
                        @endphp
                    </div>
                </div>
            </div>
        </div>

        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Semua Review ({{ $lapangan->totalReviews }})</h5>
            <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm active">Terbaru</button>
                <button class="btn btn-outline-secondary btn-sm">Rating Tertinggi</button>
                <button class="btn btn-outline-secondary btn-sm">Rating Terendah</button>
            </div>
        </div>

        
        @forelse($lapangan->reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">
                                <i class="bi bi-person-circle"></i> {{ $review->user->name }}
                            </h6>
                            <div class="mb-1">
                                {!! $review->starsHtml !!}
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> {{ $review->created_at->diffForHumans() }}
                            </small>
                        </div>
                        @if(Auth::check() && (Auth::id() === $review->user_id || Auth::user()->isAdmin()))
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @if(Auth::id() === $review->user_id)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reviews.edit', $review) }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    
                    @if($review->komentar)
                        <p class="mb-0 mt-2">{{ $review->komentar }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-chat-left-text" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada review untuk lapangan ini</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection