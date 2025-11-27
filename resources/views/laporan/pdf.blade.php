<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10b981;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #10b981;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #10b981;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #10b981;
            font-size: 16px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .stat-item h4 {
            margin: 0;
            font-size: 20px;
            color: #10b981;
        }
        .stat-item p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background: #10b981;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-warning { background: #ffc107; color: #000; }
        .status-success { background: #10b981; color: white; }
        .status-info { background: #17a2b8; color: white; }
        .status-danger { background: #dc3545; color: white; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        .summary-section {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .summary-section h3 {
            margin: 0 0 15px 0;
            color: #10b981;
            font-size: 14px;
        }
        .summary-table {
            width: 100%;
        }
        .summary-table td {
            padding: 5px;
            border: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
        .total-row {
            background: #10b981 !important;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>🏆 FUTSAL BOOKING</h1>
        <p>Laporan Booking Lapangan</p>
        <p>Periode: <strong>{{ $namaBulan }} {{ $tahun }}</strong></p>
        @if($lapangan)
            <p>Lapangan: <strong>{{ $lapangan->nama }}</strong></p>
        @endif
    </div>

    
    <div class="stats-grid">
        <div class="stat-item">
            <h4>{{ $totalBooking }}</h4>
            <p>Total Booking</p>
        </div>
        <div class="stat-item">
            <h4>Rp {{ number_format($totalPendapatan / 1000, 0) }}K</h4>
            <p>Pendapatan (Lunas)</p>
        </div>
        <div class="stat-item">
            <h4>Rp {{ number_format($totalPending / 1000, 0) }}K</h4>
            <p>Menunggu Pembayaran</p>
        </div>
        <div class="stat-item">
            <h4>{{ $totalDibatalkan }}</h4>
            <p>Dibatalkan</p>
        </div>
    </div>

    
    @if(!$lapangan && $lapanganStats->isNotEmpty())
        <div class="summary-section">
            <h3>📊 Statistik per Lapangan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th class="text-center">Jumlah Booking</th>
                        <th class="text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lapanganStats as $stat)
                        <tr>
                            <td class="fw-bold">{{ $stat['nama'] }}</td>
                            <td class="text-center">{{ $stat['count'] }}</td>
                            <td class="text-right fw-bold">Rp {{ number_format($stat['total'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    
    <div class="info-box">
        <h3>📋 Detail Booking</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 18%;">Lapangan</th>
                <th style="width: 18%;">Member</th>
                <th style="width: 15%;">Jam</th>
                <th style="width: 8%;">Durasi</th>
                <th style="width: 14%;" class="text-right">Total</th>
                <th style="width: 10%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                    <td>{{ $booking->lapangan->nama }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->jam_mulai }}-{{ $booking->jam_selesai }}</td>
                    <td>{{ $booking->durasi }} Jam</td>
                    <td class="text-right">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $booking->statusBadge }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data booking untuk periode ini</td>
                </tr>
            @endforelse
        </tbody>
        @if($bookings->isNotEmpty())
            <tfoot>
                <tr class="total-row">
                    <td colspan="6" class="text-right">TOTAL KESELURUHAN:</td>
                    <td class="text-right">Rp {{ number_format($bookings->sum('total_harga'), 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>

    
    @if($statusStats->isNotEmpty())
        <div class="summary-section">
            <h3>📈 Ringkasan per Status</h3>
            <table class="summary-table">
                @foreach($statusStats as $status => $data)
                    <tr>
                        <td style="width: 60%;">{{ $status }}</td>
                        <td style="width: 20%;" class="text-center">{{ $data['count'] }} booking</td>
                        <td style="width: 20%;" class="text-right fw-bold">
                            Rp {{ number_format($data['total'], 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    
    <div class="footer">
        <p>Dicetak pada: {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}</p>
        <p>© {{ date('Y') }} Futsal Booking. All rights reserved.</p>
    </div>
</body>
</html>