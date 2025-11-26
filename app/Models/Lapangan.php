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