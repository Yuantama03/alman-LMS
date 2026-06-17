@extends('layouts.main')
@section('title', 'Poin Siswa')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Data Poin Siswa</h4>
                            <a href="{{ route('admin.poin.create') }}" class="btn btn-primary">
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
                            <form method="GET" action="{{ route('admin.poin.index') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select name="kelas_id" class="form-control">
                                                <option value="">Semua Kelas</option>
                                                @foreach($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select name="jenis" class="form-control">
                                                <option value="">Semua Jenis</option>
                                                <option value="Prestasi" {{ request('jenis') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                <option value="Pelanggaran" {{ request('jenis') == 'Pelanggaran' ? 'selected' : '' }}>Pelanggaran</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Dari Tanggal</label>
                                            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Sampai Tanggal</label>
                                            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
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
                                            <th>Kelas</th>
                                            <th>Jenis</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th>Poin</th>
                                            <th>Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($poin as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                                <td>{{ $item->siswa->nama }}</td>
                                                <td>{{ $item->siswa->kelas->nama_kelas }}</td>
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
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.poin.edit', $item->id) }}" class="btn btn-success btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form method="POST" action="{{ route('admin.poin.destroy', $item->id) }}" style="margin-left: 8px">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete'>
                                                                <i class="fas fa-trash-alt"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data poin siswa</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Rule-Based: Status Poin Per Siswa --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Status Poin Siswa (Rule-Based)</h4>
                <a href="{{ route('admin.threshold.index') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-cog"></i> Atur Threshold
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Total Poin</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statusSiswa as $siswaId => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['nama'] }}</td>
                                <td>{{ $data['kelas'] }}</td>
                                <td class="text-center"><strong>{{ $data['total_poin'] }}</strong></td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $data['status']['color'] }}" style="font-size:13px;padding:5px 10px;">
                                        {{ $data['status']['icon'] }} {{ $data['status']['label'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data siswa</td>
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
