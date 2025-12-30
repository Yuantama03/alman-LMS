@extends('layouts.main')
@section('title', 'Edit Kegiatan Akademik')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Kegiatan Akademik</h4>
                            <a href="{{ route('admin.kalender.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                                <form action="{{ route('admin.kalender.update', $kalender->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group">
                                        <label>Judul Kegiatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                               name="judul" value="{{ old('judul', $kalender->judul) }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                                  name="deskripsi" rows="4">{{ old('deskripsi', $kalender->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Mulai <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                                       name="tanggal_mulai" 
                                                       value="{{ old('tanggal_mulai', $kalender->tanggal_mulai->format('Y-m-d')) }}" required>
                                                @error('tanggal_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Selesai</label>
                                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                                       name="tanggal_selesai" 
                                                       value="{{ old('tanggal_selesai', $kalender->tanggal_selesai ? $kalender->tanggal_selesai->format('Y-m-d') : '') }}">
                                                @error('tanggal_selesai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kegiatan <span class="text-danger">*</span></label>
                                                <select class="form-control @error('jenis_kegiatan') is-invalid @enderror" 
                                                        name="jenis_kegiatan" id="jenisKegiatan" required>
                                                    <option value="">-- Pilih Jenis --</option>
                                                    <option value="Libur" {{ old('jenis_kegiatan', $kalender->jenis_kegiatan) == 'Libur' ? 'selected' : '' }}>Libur</option>
                                                    <option value="Ujian" {{ old('jenis_kegiatan', $kalender->jenis_kegiatan) == 'Ujian' ? 'selected' : '' }}>Ujian</option>
                                                    <option value="Acara" {{ old('jenis_kegiatan', $kalender->jenis_kegiatan) == 'Acara' ? 'selected' : '' }}>Acara</option>
                                                    <option value="Pendaftaran" {{ old('jenis_kegiatan', $kalender->jenis_kegiatan) == 'Pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                                                    <option value="Pembelajaran" {{ old('jenis_kegiatan', $kalender->jenis_kegiatan) == 'Pembelajaran' ? 'selected' : '' }}>Pembelajaran</option>
                                                    <option value="Lainnya" {{ old('jenis_kegiatan', $kalender->jenis_kegiatan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                                @error('jenis_kegiatan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Warna <span class="text-danger">*</span></label>
                                                <div class="d-flex align-items-center mb-2">
                                                    <input type="color" class="form-control @error('warna') is-invalid @enderror" 
                                                           id="warnaInput" name="warna" value="{{ old('warna', $kalender->warna) }}" required style="width: 80px; height: 40px; padding: 2px;">
                                                    <span class="ml-2 text-muted small">atau pilih preset:</span>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #dc3545; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#dc3545')" title="Merah (Libur)"></button>
                                                    <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #ffc107; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#ffc107')" title="Kuning (Ujian)"></button>
                                                    <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #28a745; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#28a745')" title="Hijau (Acara)"></button>
                                                    <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #17a2b8; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#17a2b8')" title="Biru Muda (Pendaftaran)"></button>
                                                    <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #6777ef; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#6777ef')" title="Biru (Pembelajaran)"></button>
                                                    <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #6c757d; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#6c757d')" title="Abu-abu (Lainnya)"></button>
                                                </div>
                                                @error('warna')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Semester</label>
                                        <select class="form-control @error('semester_id') is-invalid @enderror" name="semester_id">
                                            <option value="">-- Pilih Semester (Opsional) --</option>
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}" 
                                                    {{ old('semester_id', $kalender->semester_id) == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->nama_semester }} - {{ $semester->tahun_ajaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('semester_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('admin.kalender.index') }}" class="btn btn-secondary">
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
