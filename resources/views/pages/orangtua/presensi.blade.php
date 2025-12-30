@extends('layouts.main')
@section('title', 'Presensi Anak')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            @foreach($presensiData as $data)
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">{{ $data['siswa']->nama }} - {{ $data['siswa']->kelas->nama_kelas }}</h5>
                    
                    <!-- Statistics -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Hadir</h4>
                                    </div>
                                    <div class="card-body">{{ $data['stats']['hadir'] }}</div>
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
                                    <div class="card-body">{{ $data['stats']['sakit'] }}</div>
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
                                    <div class="card-body">{{ $data['stats']['izin'] }}</div>
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
                                    <div class="card-body">{{ $data['stats']['alpha'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Attendance -->
                    <div class="card">
                        <div class="card-header">
                            <h4>10 Presensi Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data['presensi'] as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $p->tanggal->format('d F Y') }}</td>
                                                <td>
                                                    @if($p->status == 'Hadir')
                                                        <span class="badge badge-success">Hadir</span>
                                                    @elseif($p->status == 'Sakit')
                                                        <span class="badge badge-warning">Sakit</span>
                                                    @elseif($p->status == 'Izin')
                                                        <span class="badge badge-info">Izin</span>
                                                    @else
                                                        <span class="badge badge-danger">Alpha</span>
                                                    @endif
                                                </td>
                                                <td>{{ $p->keterangan ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada data presensi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            @endforeach

            @if(count($presensiData) == 0)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada data presensi anak.
            </div>
            @endif
        </div>
    </section>
@endsection
