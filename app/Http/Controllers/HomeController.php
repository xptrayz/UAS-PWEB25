<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Dashboard Admin
            $totalLapangan = Lapangan::count();
            $totalBooking = Booking::count();
            $bookingHariIni = Booking::whereDate('tanggal_booking', today())->count();
            $pendapatanBulanIni = Booking::whereMonth('created_at', now()->month)
                                        ->where('status', 'Lunas')
                                        ->sum('total_harga');
            
            $recentBookings = Booking::with(['user', 'lapangan'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
            
            return view('home', compact(
                'totalLapangan', 
                'totalBooking', 
                'bookingHariIni', 
                'pendapatanBulanIni',
                'recentBookings'
            ));
        } else {
            // Dashboard Member
            $myBookings = Auth::user()->bookings()
                             ->with('lapangan')
                             ->latest()
                             ->take(5)
                             ->get();
            
            $totalBooking = Auth::user()->bookings()->count();
            $bookingAktif = Auth::user()->bookings()
                                ->whereIn('status', ['Menunggu Pembayaran', 'Lunas'])
                                ->count();
            $totalSpending = Auth::user()->bookings()
                                ->where('status', 'Lunas')
                                ->sum('total_harga');
            
            return view('home', compact(
                'myBookings', 
                'totalBooking', 
                'bookingAktif',
                'totalSpending'
            ));
        }
    }
}