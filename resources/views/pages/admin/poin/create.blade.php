@extends('layouts.main')
@section('title', 'Tambah Poin Siswa')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tambah Poin Siswa</h4>
                            <a href="{{ route('admin.poin.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            
                            <form action="{{ route('admin.poin.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Siswa <span class="text-danger">*</span></label>
                                            <select name="siswa_id" class="form-control select2 @error('siswa_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Siswa --</option>
                                                @foreach($siswa as $s)
                                                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                                        {{ $s->nama }} - {{ $s->kelas->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('siswa_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis <span class="text-danger">*</span></label>
                                            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                                                <option value="">-- Pilih Jenis --</option>
                                                <option value="Prestasi" {{ old('jenis') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                <option value="Pelanggaran" {{ old('jenis') == 'Pelanggaran' ? 'selected' : '' }}>Pelanggaran</option>
                                            </select>
                                            @error('jenis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kategori <span class="text-danger">*</span></label>
                                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" 
                                                   value="{{ old('kategori') }}" placeholder="Contoh: Juara Lomba, Terlambat, dll" required>
                                            @error('kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Poin <span class="text-danger">*</span></label>
                                            <input type="number" name="poin" class="form-control @error('poin') is-invalid @enderror" 
                                                   value="{{ old('poin') }}" min="1" placeholder="Masukkan jumlah poin" required>
                                            <small class="text-muted">Masukkan nilai positif</small>
                                            @error('poin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                            @error('tanggal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                              rows="4" placeholder="Jelaskan detail prestasi atau pelanggaran" required>{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <a href="{{ route('admin.poin.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
