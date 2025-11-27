@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content-wrapper">
                <h2 class="fw-bold mb-4">
                    <i class="bi bi-star"></i> Berikan Review
                </h2>

                
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            @if($booking->lapangan->foto)
                                <div class="col-md-3">
                                    <img src="{{ Storage::url($booking->lapangan->foto) }}" 
                                         alt="{{ $booking->lapangan->nama }}" 
                                         class="img-fluid rounded">
                                </div>
                            @endif
                            <div class="{{ $booking->lapangan->foto ? 'col-md-9' : 'col-12' }}">
                                <h4 class="fw-bold mb-2">{{ $booking->lapangan->nama }}</h4>
                                <p class="mb-1">
                                    <i class="bi bi-calendar"></i> {{ $booking->tanggal_booking->format('d M Y') }}
                                </p>
                                <p class="mb-1">
                                    <i class="bi bi-clock"></i> {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('reviews.store', $booking->id) }}" method="POST">
                            @csrf

                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-star-fill text-warning"></i> Rating
                                </label>
                                <div class="rating-input">
                                    <div class="star-rating" id="starRating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star star" data-rating="{{ $i }}" style="font-size: 2.5rem; cursor: pointer;"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}" required>
                                    <p class="text-muted mt-2 mb-0" id="ratingText">Klik bintang untuk memberikan rating</p>
                                    @error('rating')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-chat-left-text"></i> Komentar (Opsional)
                                </label>
                                <textarea class="form-control @error('komentar') is-invalid @enderror" 
                                          name="komentar" rows="5" 
                                          placeholder="Ceritakan pengalaman Anda bermain di lapangan ini...">{{ old('komentar') }}</textarea>
                                <small class="text-muted">Maksimal 1000 karakter</small>
                                @error('komentar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Kirim Review
                                </button>
                                <a href="{{ route('booking.show', $booking) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');
    const ratingLabels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
    
    let selectedRating = {{ old('rating', 0) }};
    
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('bi-star');
                star.classList.add('bi-star-fill', 'text-warning');
            } else {
                star.classList.remove('bi-star-fill', 'text-warning');
                star.classList.add('bi-star');
            }
        });
    }
    
    
    if (selectedRating > 0) {
        updateStars(selectedRating);
        ratingText.textContent = ratingLabels[selectedRating];
    }
    
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            ratingInput.value = selectedRating;
            updateStars(selectedRating);
            ratingText.textContent = ratingLabels[selectedRating];
        });
        
        star.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.dataset.rating);
            updateStars(hoverRating);
            ratingText.textContent = ratingLabels[hoverRating];
        });
    });
    
    document.getElementById('starRating').addEventListener('mouseleave', function() {
        updateStars(selectedRating);
        if (selectedRating > 0) {
            ratingText.textContent = ratingLabels[selectedRating];
        } else {
            ratingText.textContent = 'Klik bintang untuk memberikan rating';
        }
    });
</script>
@endsection