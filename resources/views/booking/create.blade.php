@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content-wrapper">
                <h2 class="fw-bold mb-4">
                    <i class="bi bi-calendar-plus"></i> Buat Booking Baru
                </h2>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Lapangan</label>
                        <select class="form-select @error('lapangan_id') is-invalid @enderror" 
                                name="lapangan_id" id="lapangan_id" required>
                            <option value="">-- Pilih Lapangan --</option>
                            @foreach($lapangans as $lapangan)
                                <option value="{{ $lapangan->id }}" 
                                        data-harga="{{ $lapangan->harga_per_jam }}"
                                        {{ old('lapangan_id') == $lapangan->id ? 'selected' : '' }}>
                                    {{ $lapangan->nama }} - {{ $lapangan->jenis }} 
                                    (Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}/jam)
                                </option>
                            @endforeach
                        </select>
                        @error('lapangan_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Booking</label>
                        <input type="date" class="form-control @error('tanggal_booking') is-invalid @enderror" 
                               name="tanggal_booking" id="tanggal_booking" 
                               value="{{ old('tanggal_booking', date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" required>
                        @error('tanggal_booking')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam Mulai</label>
                        <select class="form-select @error('jam_mulai') is-invalid @enderror" 
                                name="jam_mulai" id="jam_mulai" required>
                            <option value="">-- Pilih Jam --</option>
                            @for($i = 6; $i <= 22; $i++)
                                <option value="{{ sprintf('%02d:00', $i) }}" 
                                        {{ old('jam_mulai') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                    {{ sprintf('%02d:00', $i) }}
                                </option>
                            @endfor
                        </select>
                        @error('jam_mulai')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Durasi (Jam)</label>
                        <select class="form-select @error('durasi') is-invalid @enderror" 
                                name="durasi" id="durasi" required>
                            <option value="">-- Pilih Durasi --</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ old('durasi') == $i ? 'selected' : '' }}>
                                    {{ $i }} Jam
                                </option>
                            @endfor
                        </select>
                        @error('durasi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan (Opsional)</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  name="catatan" rows="3" 
                                  placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Ringkasan Booking</h5>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-2"><strong>Harga per Jam:</strong></p>
                                    <p class="mb-2"><strong>Durasi:</strong></p>
                                    <hr>
                                    <p class="mb-0"><strong>Total Harga:</strong></p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-2" id="harga-display">Rp 0</p>
                                    <p class="mb-2" id="durasi-display">0 Jam</p>
                                    <hr>
                                    <h4 class="text-primary mb-0" id="total-display">Rp 0</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Konfirmasi Booking
                        </button>
                        <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function hitungTotal() {
        const lapangan = document.getElementById('lapangan_id');
        const durasi = document.getElementById('durasi');
        
        if (lapangan.value && durasi.value) {
            const harga = parseInt(lapangan.options[lapangan.selectedIndex].dataset.harga);
            const dur = parseInt(durasi.value);
            const total = harga * dur;
            
            document.getElementById('harga-display').textContent = 
                'Rp ' + harga.toLocaleString('id-ID');
            document.getElementById('durasi-display').textContent = dur + ' Jam';
            document.getElementById('total-display').textContent = 
                'Rp ' + total.toLocaleString('id-ID');
        }
    }
    
    document.getElementById('lapangan_id').addEventListener('change', hitungTotal);
    document.getElementById('durasi').addEventListener('change', hitungTotal);
    
    
    window.addEventListener('load', hitungTotal);
</script>
@endsection