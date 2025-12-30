@extends('layouts.main')
@section('title', 'Edit Semester')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('partials.alert')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Semester {{ $semester->nama_semester }} - {{ $semester->tahun_ajaran }}</h4>
                            <a href="{{ route('semester.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('semester.update', $semester->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama_semester">Nama Semester</label>
                                    <select id="nama_semester" name="nama_semester" class="form-control @error('nama_semester') is-invalid @enderror">
                                        <option value="">-- Pilih Semester --</option>
                                        <option value="Ganjil" {{ $semester->nama_semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="Genap" {{ $semester->nama_semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran</label>
                                    <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" placeholder="2024/2025" value="{{ $semester->tahun_ajaran }}">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ $semester->tanggal_mulai->format('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ $semester->tanggal_selesai->format('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="status_aktif" name="status_aktif" value="1" {{ $semester->status_aktif ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_aktif">Aktifkan Semester</label>
                                    </div>
                                    <small class="form-text text-muted">Jika dicentang, semester lain akan dinonaktifkan secara otomatis</small>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
