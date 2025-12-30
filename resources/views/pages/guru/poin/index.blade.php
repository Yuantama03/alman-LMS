@extends('layouts.main')
@section('title', 'Poin Siswa')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Poin Kelas {{ $kelas->nama_kelas }}</h4>
                            <a href="{{ route('guru.poin.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Poin
                            </a>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            
                            <!-- Statistics -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-success">
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Total Prestasi</h4>
                                            </div>
                                            <div class="card-body">{{ $totalPrestasi }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Total Pelanggaran</h4>
                                            </div>
                                            <div class="card-body">{{ abs($totalPelanggaran) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter -->
                            <form method="GET" action="{{ route('guru.poin.index') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select name="jenis" class="form-control">
                                                <option value="">Semua Jenis</option>
                                                <option value="Prestasi" {{ request('jenis') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                <option value="Pelanggaran" {{ request('jenis') == 'Pelanggaran' ? 'selected' : '' }}>Pelanggaran</option>
                                            </select>
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

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Siswa</th>
                                            <th>Jenis</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th>Poin</th>
                                            <th>Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($poin as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                                <td>{{ $item->siswa->nama }}</td>
                                                <td>
                                                    @if($item->jenis == 'Prestasi')
                                                        <span class="badge badge-success">{{ $item->jenis }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $item->jenis }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->kategori }}</td>
                                                <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                                <td>
                                                    @if($item->poin > 0)
                                                        <span class="badge badge-success">+{{ $item->poin }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $item->poin }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->creator->name }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data poin siswa</td>
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
