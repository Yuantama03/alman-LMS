@extends('layouts.main')
@section('title', 'Presensi Siswa')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Data Presensi Siswa</h4>
                            <a href="{{ route('admin.presensi.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Input Presensi
                            </a>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            
                            <!-- Filter -->
                            <form method="GET" action="{{ route('admin.presensi.index') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select name="kelas_id" class="form-control">
                                                <option value="">Semua Kelas</option>
                                                @foreach($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control" value="{{ $selectedDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Statistics -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-success">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Hadir</h4>
                                            </div>
                                            <div class="card-body">{{ $stats['hadir'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-warning">
                                            <i class="fas fa-notes-medical"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Sakit</h4>
                                            </div>
                                            <div class="card-body">{{ $stats['sakit'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-info">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Izin</h4>
                                            </div>
                                            <div class="card-body">{{ $stats['izin'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-danger">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Alpha</h4>
                                            </div>
                                            <div class="card-body">{{ $stats['alpha'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>NIS</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($presensi as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->tanggal->format('d/m/Y') }}</td>
                                                <td>{{ $data->siswa->nis }}</td>
                                                <td>{{ $data->siswa->nama }}</td>
                                                <td>{{ $data->kelas->nama_kelas }}</td>
                                                <td>
                                                    @if($data->status == 'Hadir')
                                                        <span class="badge badge-success">Hadir</span>
                                                    @elseif($data->status == 'Sakit')
                                                        <span class="badge badge-warning">Sakit</span>
                                                    @elseif($data->status == 'Izin')
                                                        <span class="badge badge-info">Izin</span>
                                                    @else
                                                        <span class="badge badge-danger">Alpha</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->keterangan ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data presensi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
