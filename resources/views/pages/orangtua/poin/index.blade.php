@extends('layouts.main')
@section('title', 'Poin Siswa')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <!-- Summary Cards per Child -->
            <div class="row">
                @foreach($totals as $siswaId => $data)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-user"></i> {{ $data['nama'] }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div class="text-primary">
                                            <h5>{{ $data['total'] }}</h5>
                                            <small>Total</small>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="text-success">
                                            <h5>+{{ $data['prestasi'] }}</h5>
                                            <small>Prestasi</small>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="text-danger">
                                            <h5>{{ $data['pelanggaran'] }}</h5>
                                            <small>Pelanggaran</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Riwayat Poin Anak</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Siswa</th>
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
                                                <td><strong>{{ $item->siswa->nama }}</strong></td>
                                                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($item->jenis == 'Prestasi')
                                                        <span class="badge badge-success"><i class="fas fa-trophy"></i> {{ $item->jenis }}</span>
                                                    @else
                                                        <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> {{ $item->jenis }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->kategori }}</td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td>
                                                    @if($item->poin > 0)
                                                        <span class="badge badge-success badge-lg">+{{ $item->poin }}</span>
                                                    @else
                                                        <span class="badge badge-danger badge-lg">{{ $item->poin }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->creator->name }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Belum ada data poin</td>
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
