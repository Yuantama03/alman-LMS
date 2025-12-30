@extends('layouts.main')
@section('title', 'Poin Saya')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <!-- Summary Cards -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Poin</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPoin }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Prestasi</h4>
                            </div>
                            <div class="card-body">
                                +{{ $totalPrestasi }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pelanggaran</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPelanggaran }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Riwayat Poin</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th>Poin</th>
                                            <th>Dicatat Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($poin as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($item->jenis == 'Prestasi')
                                                        <span class="badge badge-success"><i class="fas fa-trophy"></i> {{ $item->jenis }}</span>
                                                    @else
                                                        <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> {{ $item->jenis }}</span>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $item->kategori }}</strong></td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td>
                                                    @if($item->poin > 0)
                                                        <span class="badge badge-success badge-lg" style="font-size: 14px;">+{{ $item->poin }}</span>
                                                    @else
                                                        <span class="badge badge-danger badge-lg" style="font-size: 14px;">{{ $item->poin }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->creator->name }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada data poin</td>
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
