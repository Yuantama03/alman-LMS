@extends('layouts.main')
@section('title', 'Input Presensi')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('partials.alert')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Input Presensi Siswa</h4>
                            <a href="{{ route('admin.presensi.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('admin.presensi.create') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pilih Kelas <span class="text-danger">*</span></label>
                                            <select name="kelas_id" class="form-control" required onchange="this.form.submit()">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" required onchange="this.form.submit()">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if($selectedKelas && count($siswas) > 0)
                            <!-- Presensi Form -->
                            <form method="POST" action="{{ route('admin.presensi.store') }}">
                                @csrf
                                <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
                                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> 
                                    Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</strong>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="15%">NIS</th>
                                                <th width="25%">Nama Siswa</th>
                                                <th width="20%">Status</th>
                                                <th width="35%">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($siswas as $siswa)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>
                                                    <select name="presensi[{{ $siswa->id }}]" class="form-control" required>
                                                        <option value="Hadir" {{ (isset($existingPresensi[$siswa->id]) && $existingPresensi[$siswa->id] == 'Hadir') ? 'selected' : '' }}>Hadir</option>
                                                        <option value="Sakit" {{ (isset($existingPresensi[$siswa->id]) && $existingPresensi[$siswa->id] == 'Sakit') ? 'selected' : '' }}>Sakit</option>
                                                        <option value="Izin" {{ (isset($existingPresensi[$siswa->id]) && $existingPresensi[$siswa->id] == 'Izin') ? 'selected' : '' }}>Izin</option>
                                                        <option value="Alpha" {{ (isset($existingPresensi[$siswa->id]) && $existingPresensi[$siswa->id] == 'Alpha') ? 'selected' : '' }}>Alpha</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="keterangan[{{ $siswa->id }}]" class="form-control" placeholder="Keterangan (opsional)">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Simpan Presensi
                                    </button>
                                </div>
                            </form>
                            @elseif($selectedKelas)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Tidak ada siswa di kelas ini.
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Silakan pilih kelas dan tanggal terlebih dahulu.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
