<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'durasi',
        'total_harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    
    public function canBeReviewed()
    {
        return $this->status === 'Selesai' && !$this->review;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Menunggu Pembayaran' => 'warning',
            'Lunas' => 'success',
            'Selesai' => 'info',
            'Dibatalkan' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}