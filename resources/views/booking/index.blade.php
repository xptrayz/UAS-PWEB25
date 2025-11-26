@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-calendar-check"></i> 
                    @if(Auth::user()->isAdmin())
                        Semua Booking
                    @else
                        Booking Saya
                    @endif
                </h2>
                <p class="text-muted mb-0">
                    @if(Auth::user()->isAdmin())
                        Kelola semua booking dari member
                    @else
                        Lihat riwayat dan status booking Anda
                    @endif
                </p>
            </div>
            @if(Auth::user()->isMember())
                <a href="{{ route('booking.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Booking Baru
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        @if(Auth::user()->isAdmin())
                            <th>Member</th>
                        @endif
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="fw-bold">#{{ $booking->id }}</td>
                            @if(Auth::user()->isAdmin())
                                <td>
                                    <i class="bi bi-person"></i> {{ $booking->user->name }}
                                    <br><small class="text-muted">{{ $booking->user->email }}</small>
                                </td>
                            @endif
                            <td>
                                <strong>{{ $booking->lapangan->nama }}</strong>
                                <br><small class="text-muted">{{ $booking->lapangan->jenis }}</small>
                            </td>
                            <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
                            <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                            <td>{{ $booking->durasi }} Jam</td>
                            <td class="fw-bold text-primary">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $booking->statusBadge }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td>
                                @if(Auth::user()->isAdmin())
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <h6 class="dropdown-header">Ubah Status</h6>
                                            </li>
                                            @foreach(['Menunggu Pembayaran', 'Lunas', 'Selesai', 'Dibatalkan'] as $status)
                                                <li>
                                                    <form action="{{ route('booking.updateStatus', $booking) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="{{ $status }}">
                                                        <button type="submit" class="dropdown-item" 
                                                                {{ $booking->status == $status ? 'disabled' : '' }}>
                                                            {{ $status }}
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('booking.show', $booking) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isAdmin() ? '9' : '8' }}" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">Belum ada booking</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection