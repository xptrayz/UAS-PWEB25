@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content-wrapper">
                <h2 class="fw-bold mb-4">
                    <i class="bi bi-pencil-square"></i> Edit Lapangan
                </h2>

                <form action="{{ route('lapangan.update', $lapangan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lapangan</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               name="nama" value="{{ old('nama', $lapangan->nama) }}" required
                               placeholder="Contoh: Lapangan A">
                        @error('nama')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Lapangan</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Sintetis" {{ old('jenis', $lapangan->jenis) == 'Sintetis' ? 'selected' : '' }}>Sintetis</option>
                            <option value="Vinyl" {{ old('jenis', $lapangan->jenis) == 'Vinyl' ? 'selected' : '' }}>Vinyl</option>
                            <option value="Rumput Asli" {{ old('jenis', $lapangan->jenis) == 'Rumput Asli' ? 'selected' : '' }}>Rumput Asli</option>
                        </select>
                        @error('jenis')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga per Jam (Rp)</label>
                        <input type="number" class="form-control @error('harga_per_jam') is-invalid @enderror" 
                               name="harga_per_jam" value="{{ old('harga_per_jam', $lapangan->harga_per_jam) }}" required
                               placeholder="Contoh: 150000">
                        @error('harga_per_jam')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="Tersedia" {{ old('status', $lapangan->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Dalam Perbaikan" {{ old('status', $lapangan->status) == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                            <option value="Tidak Aktif" {{ old('status', $lapangan->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  name="deskripsi" rows="3" 
                                  placeholder="Deskripsi lapangan (opsional)">{{ old('deskripsi', $lapangan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Foto Lapangan</label>
                        
                        @if($lapangan->foto)
                            <div class="mb-2">
                                <img src="{{ Storage::url($lapangan->foto) }}" 
                                     alt="Foto Lapangan" 
                                     class="img-thumbnail" 
                                     style="max-height: 200px;">
                                <p class="text-muted small mt-1">Foto saat ini</p>
                            </div>
                        @endif
                        
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               name="foto" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB) - Kosongkan jika tidak ingin mengubah foto</small>
                        @error('foto')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
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