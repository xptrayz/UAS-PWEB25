@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-file-earmark-bar-graph"></i> Preview Laporan
                </h2>
                <p class="text-muted mb-0">
                    Laporan Booking {{ $namaBulan }} {{ $tahun }}
                    @if($lapangan)
                        - {{ $lapangan->nama }}
                    @endif
                </p>
            </div>
            <div>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('laporan.cetakPdf', request()->all()) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
            </div>
        </div>

        
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-1">Total Booking</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalBooking }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="mb-1">Pendapatan (Lunas)</h6>
                        <h2 class="mb-0 fw-bold">Rp {{ number_format($totalPendapatan / 1000, 0) }}K</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="mb-1">Pending</h6>
                        <h2 class="mb-0 fw-bold">Rp {{ number_format($totalPending / 1000, 0) }}K</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6 class="mb-1">Dibatalkan</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalDibatalkan }}</h2>
                    </div>
                </div>
            </div>
        </div>

        
        @if(!$lapangan && $lapanganStats->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart"></i> Statistik per Lapangan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Lapangan</th>
                                    <th class="text-center">Jumlah Booking</th>
                                    <th class="text-end">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lapanganStats as $stat)
                                    <tr>
                                        <td class="fw-bold">{{ $stat['nama'] }}</td>
                                        <td class="text-center">{{ $stat['count'] }}</td>
                                        <td class="text-end fw-bold text-success">
                                            Rp {{ number_format($stat['total'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul"></i> Detail Booking
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Lapangan</th>
                                <th>Member</th>
                                <th>Jam</th>
                                <th>Durasi</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                                    <td>{{ $booking->lapangan->nama }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                    <td>{{ $booking->durasi }} Jam</td>
                                    <td class="fw-bold">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->statusBadge }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Tidak ada data booking untuk periode ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($bookings->isNotEmpty())
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="6" class="text-end">Total:</th>
                                    <th>Rp {{ number_format($bookings->sum('total_harga'), 0, ',', '.') }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection