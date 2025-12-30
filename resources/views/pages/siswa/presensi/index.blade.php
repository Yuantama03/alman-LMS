@extends('layouts.main')
@section('title', 'Presensi Saya')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <!-- Statistics -->
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Riwayat Presensi Saya</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                Statistik menampilkan data bulan <strong>{{ \Carbon\Carbon::now()->format('F Y') }}</strong>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($presensi as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->tanggal->format('d F Y') }}</td>
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
                                                <td colspan="4" class="text-center">Belum ada data presensi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $presensi->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
