@extends('layouts.main')
@section('title', 'Edit Silabus')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('partials.alert')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Silabus</h4>
                            <a href="{{ route('silabus.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('silabus.update', $silabus->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mapel_id">Mata Pelajaran</label>
                                            <select id="mapel_id" name="mapel_id" class="select2bs4 form-control @error('mapel_id') is-invalid @enderror">
                                                <option value="">-- Pilih Mata Pelajaran --</option>
                                                @foreach ($mapels as $mapel)
                                                    <option value="{{ $mapel->id }}" {{ $silabus->mapel_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kelas_id">Kelas</label>
                                            <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ $silabus->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="semester_id">Semester</label>
                                            <select id="semester_id" name="semester_id" class="select2bs4 form-control @error('semester_id') is-invalid @enderror">
                                                <option value="">-- Pilih Semester --</option>
                                                @foreach ($semesters as $semester)
                                                    <option value="{{ $semester->id }}" {{ $silabus->semester_id == $semester->id ? 'selected' : '' }}>{{ $semester->nama_semester }} - {{ $semester->tahun_ajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alokasi_waktu">Alokasi Waktu (menit)</label>
                                            <input type="number" id="alokasi_waktu" name="alokasi_waktu" class="form-control @error('alokasi_waktu') is-invalid @enderror" placeholder="90" value="{{ $silabus->alokasi_waktu }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="2" placeholder="Deskripsi silabus">{{ $silabus->deskripsi }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="kompetensi_dasar">Kompetensi Dasar</label>
                                    <textarea id="kompetensi_dasar" name="kompetensi_dasar" class="form-control @error('kompetensi_dasar') is-invalid @enderror" rows="3" placeholder="Kompetensi dasar yang harus dicapai">{{ $silabus->kompetensi_dasar }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tujuan_pembelajaran">Tujuan Pembelajaran</label>
                                    <textarea id="tujuan_pembelajaran" name="tujuan_pembelajaran" class="form-control @error('tujuan_pembelajaran') is-invalid @enderror" rows="3" placeholder="Tujuan pembelajaran">{{ $silabus->tujuan_pembelajaran }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="materi_pokok">Materi Pokok</label>
                                    <textarea id="materi_pokok" name="materi_pokok" class="form-control @error('materi_pokok') is-invalid @enderror" rows="3" placeholder="Materi pokok yang akan diajarkan">{{ $silabus->materi_pokok }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="metode_pembelajaran">Metode Pembelajaran</label>
                                    <textarea id="metode_pembelajaran" name="metode_pembelajaran" class="form-control @error('metode_pembelajaran') is-invalid @enderror" rows="3" placeholder="Metode yang digunakan dalam pembelajaran">{{ $silabus->metode_pembelajaran }}</textarea>
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
