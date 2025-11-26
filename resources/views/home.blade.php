@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-speedometer2"></i> Dashboard
            </h2>
            <p class="text-muted mb-0">
                Selamat datang, <strong>{{ Auth::user()->name }}</strong>! 
                @if(Auth::user()->isAdmin())
                    <span class="badge bg-danger">Admin</span>
                @endif
            </p>
        </div>

        @if(Auth::user()->isAdmin())
            <!-- Admin Dashboard -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Total Lapangan</h6>
                                    <h2 class="mb-0 fw-bold">{{ $totalLapangan }}</h2>
                                </div>
                                <i class="bi bi-grid" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Total Booking</h6>
                                    <h2 class="mb-0 fw-bold">{{ $totalBooking }}</h2>
                                </div>
                                <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Booking Hari Ini</h6>
                                    <h2 class="mb-0 fw-bold">{{ $bookingHariIni }}</h2>
                                </div>
                                <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Pendapatan Bulan Ini</h6>
                                    <h2 class="mb-0 fw-bold">Rp {{ number_format($pendapatanBulanIni / 1000, 0) }}K</h2>
                                </div>
                                <i class="bi bi-cash-stack" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-clock-history"></i> Booking Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Member</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                    <tr>
                                        <td class="fw-bold">#{{ $booking->id }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->lapangan->nama }}</td>
                                        <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
                                        <td class="fw-bold text-primary">
                                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $booking->statusBadge }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('booking.index') }}" class="btn btn-sm btn-outline-primary">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Belum ada booking
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <a href="{{ route('lapangan.index') }}" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-grid"></i> Kelola Lapangan
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('booking.index') }}" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-calendar-check"></i> Lihat Semua Booking
                    </a>
                </div>
            </div>

        @else
            <!-- Member Dashboard -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Total Booking</h6>
                                    <h2 class="mb-0 fw-bold">{{ $totalBooking }}</h2>
                                </div>
                                <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Booking Aktif</h6>
                                    <h2 class="mb-0 fw-bold">{{ $bookingAktif }}</h2>
                                </div>
                                <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Total Pengeluaran</h6>
                                    <h2 class="mb-0 fw-bold">Rp {{ number_format($totalSpending / 1000, 0) }}K</h2>
                                </div>
                                <i class="bi bi-cash-stack" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-clock-history"></i> Booking Terbaru Saya
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myBookings as $booking)
                                    <tr>
                                        <td class="fw-bold">#{{ $booking->id }}</td>
                                        <td>{{ $booking->lapangan->nama }}</td>
                                        <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
                                        <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                        <td class="fw-bold text-primary">
                                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $booking->statusBadge }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('booking.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Belum ada booking
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('lapangan.index') }}" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-grid"></i> Lihat Lapangan
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('booking.create') }}" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-plus-circle"></i> Booking Baru
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection