@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan Booking
            </h2>
            <p class="text-muted mb-0">Generate laporan booking per bulan dalam format PDF</p>
        </div>

        <div class="row">
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-funnel"></i> Filter Laporan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.preview') }}" method="GET" id="filterForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-calendar-month"></i> Bulan
                                </label>
                                <select name="bulan" class="form-select" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="1" {{ date('n') == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ date('n') == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ date('n') == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ date('n') == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ date('n') == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ date('n') == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ date('n') == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ date('n') == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ date('n') == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ date('n') == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ date('n') == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ date('n') == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-calendar"></i> Tahun
                                </label>
                                <select name="tahun" class="form-select" required>
                                    <option value="">Pilih Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-stadium"></i> Lapangan (Opsional)
                                </label>
                                <select name="lapangan_id" class="form-select">
                                    <option value="">Semua Lapangan</option>
                                    @foreach($lapangans as $lapangan)
                                        <option value="{{ $lapangan->id }}">{{ $lapangan->nama }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Kosongkan untuk melihat semua lapangan</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-eye"></i> Preview Laporan
                                </button>
                                <button type="button" class="btn btn-success" onclick="cetakPdf()">
                                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle"></i> Informasi
                        </h6>
                        <ul class="small mb-0">
                            <li>Laporan menampilkan semua booking pada bulan yang dipilih</li>
                            <li>Data dapat difilter berdasarkan lapangan tertentu</li>
                            <li>Preview untuk melihat sebelum download</li>
                            <li>Download PDF untuk arsip dan cetak</li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-file-earmark-text"></i> Preview Laporan
                        </h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <i class="bi bi-file-earmark-bar-graph" style="font-size: 5rem; color: #ccc;"></i>
                        <p class="text-muted mt-3 mb-0">
                            Pilih bulan dan tahun, lalu klik "Preview Laporan" untuk melihat data
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function cetakPdf() {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        
        if (!formData.get('bulan') || !formData.get('tahun')) {
            alert('Silakan pilih bulan dan tahun terlebih dahulu!');
            return;
        }
        
        
        window.location.href = '{{ route("laporan.cetakPdf") }}?' + params.toString();
    }
</script>
@endsection