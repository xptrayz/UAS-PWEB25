<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        
        $lapangans = Lapangan::all();
        $years = Booking::selectRaw('YEAR(tanggal_booking) as year')
                       ->distinct()
                       ->orderBy('year', 'desc')
                       ->pluck('year');
        
        if ($years->isEmpty()) {
            $years = collect([date('Y')]);
        }

        return view('laporan.index', compact('lapangans', 'years'));
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'lapangan_id' => 'nullable|exists:lapangans,id',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $lapanganId = $validated['lapangan_id'] ?? null;

        $data = $this->getLaporanData($bulan, $tahun, $lapanganId);

        return view('laporan.preview', $data);
    }

    public function cetakPdf(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'lapangan_id' => 'nullable|exists:lapangans,id',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $lapanganId = $validated['lapangan_id'] ?? null;

        $data = $this->getLaporanData($bulan, $tahun, $lapanganId);

        $pdf = Pdf::loadView('laporan.pdf', $data)
                  ->setPaper('a4', 'portrait');

        $namaBulan = $this->getNamaBulan($bulan);
        $namaFile = 'Laporan_Booking_' . $namaBulan . '_' . $tahun . '.pdf';

        return $pdf->download($namaFile);
    }

    private function getLaporanData($bulan, $tahun, $lapanganId = null)
    {
        $query = Booking::with(['user', 'lapangan'])
                        ->whereMonth('tanggal_booking', $bulan)
                        ->whereYear('tanggal_booking', $tahun);

        if ($lapanganId) {
            $query->where('lapangan_id', $lapanganId);
            $lapangan = Lapangan::find($lapanganId);
        } else {
            $lapangan = null;
        }

        $bookings = $query->orderBy('tanggal_booking')
                         ->orderBy('jam_mulai')
                         ->get();

        
        $totalBooking = $bookings->count();
        $totalPendapatan = $bookings->where('status', 'Lunas')->sum('total_harga');
        $totalPending = $bookings->where('status', 'Menunggu Pembayaran')->sum('total_harga');
        $totalDibatalkan = $bookings->where('status', 'Dibatalkan')->count();

        
        $statusStats = $bookings->groupBy('status')->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total_harga'),
            ];
        });

        
        $lapanganStats = $bookings->groupBy('lapangan_id')->map(function ($items) {
            return [
                'nama' => $items->first()->lapangan->nama,
                'count' => $items->count(),
                'total' => $items->where('status', 'Lunas')->sum('total_harga'),
            ];
        })->sortByDesc('total');

        $namaBulan = $this->getNamaBulan($bulan);

        return compact(
            'bookings',
            'bulan',
            'tahun',
            'namaBulan',
            'lapangan',
            'totalBooking',
            'totalPendapatan',
            'totalPending',
            'totalDibatalkan',
            'statusStats',
            'lapanganStats'
        );
    }

    private function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $namaBulan[$bulan];
    }
}