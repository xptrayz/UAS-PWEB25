<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'harga_per_jam',
        'deskripsi',
        'status',
        'foto',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    
    public function getStarsHtmlAttribute()
    {
        $rating = round($this->averageRating, 1);
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        $html = '';
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '<i class="bi bi-star-fill text-warning"></i>';
        }
        if ($halfStar) {
            $html .= '<i class="bi bi-star-half text-warning"></i>';
        }
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '<i class="bi bi-star text-muted"></i>';
        }
        return $html;
    }

    public function isAvailable($tanggal, $jamMulai, $jamSelesai)
    {
        return !$this->bookings()
            ->where('tanggal_booking', $tanggal)
            ->where('status', '!=', 'Dibatalkan')
            ->where(function($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                      ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                      ->orWhere(function($q) use ($jamMulai, $jamSelesai) {
                          $q->where('jam_mulai', '<=', $jamMulai)
                            ->where('jam_selesai', '>=', $jamSelesai);
                      });
            })
            ->exists();
    }
}