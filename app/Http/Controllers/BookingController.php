<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $bookings = Booking::with(['user', 'lapangan'])->latest()->get();
        } else {
            $bookings = Auth::user()->bookings()->with('lapangan')->latest()->get();
        }

        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        $lapangans = Lapangan::where('status', 'Tersedia')->get();
        return view('booking.create', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'durasi' => 'required|integer|min:1|max:8',
            'catatan' => 'nullable|string',
        ]);

        $lapangan = Lapangan::findOrFail($validated['lapangan_id']);
        
        $jamMulai = Carbon::parse($validated['jam_mulai']);
        $jamSelesai = $jamMulai->copy()->addHours((int) $validated['durasi']);

        if (!$lapangan->isAvailable($validated['tanggal_booking'], $validated['jam_mulai'], $jamSelesai->format('H:i'))) {
            return back()->withErrors(['error' => 'Jadwal yang dipilih tidak tersedia!'])->withInput();
        }

        $validated['user_id'] = Auth::id();
        $validated['jam_selesai'] = $jamSelesai->format('H:i');
        $validated['total_harga'] = $lapangan->harga_per_jam * $validated['durasi'];

        Booking::create($validated);

        return redirect()->route('booking.index')->with('success', 'Booking berhasil dibuat!');
    }

    public function show(Booking $booking)
    {
        if (Auth::user()->isMember() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Menunggu Pembayaran,Lunas,Selesai,Dibatalkan',
        ]);

        $booking->update($validated);

        return back()->with('success', 'Status booking berhasil diupdate!');
    }

    public function checkAvailability(Request $request)
    {
        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        $tanggal = $request->tanggal;
        
        $bookings = $lapangan->bookings()
            ->where('tanggal_booking', $tanggal)
            ->where('status', '!=', 'Dibatalkan')
            ->get(['jam_mulai', 'jam_selesai']);

        return response()->json(['bookings' => $bookings]);
    }
}