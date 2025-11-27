<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function create($bookingId)
    {
        $booking = Booking::with('lapangan')->findOrFail($bookingId);

        
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        
        if (!$booking->canBeReviewed()) {
            return redirect()->route('booking.index')
                ->with('error', 'Booking ini belum bisa di-review atau sudah pernah di-review.');
        }

        return view('reviews.create', compact('booking'));
    }

    
    public function store(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$booking->canBeReviewed()) {
            return back()->with('error', 'Booking ini belum bisa di-review atau sudah pernah di-review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $booking->lapangan_id,
            'booking_id' => $booking->id,
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'],
        ]);

        return redirect()->route('booking.show', $booking)
            ->with('success', 'Review berhasil ditambahkan! Terima kasih atas feedback Anda.');
    }

    
    public function index($lapanganId)
    {
        $lapangan = Lapangan::with(['reviews' => function($query) {
            $query->latest();
        }, 'reviews.user'])->findOrFail($lapanganId);

        return view('reviews.index', compact('lapangan'));
    }

    
    public function edit(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('reviews.edit', compact('review'));
    }

    
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('reviews.lapangan', $review->lapangan_id)
            ->with('success', 'Review berhasil diupdate!');
    }

    
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }
}