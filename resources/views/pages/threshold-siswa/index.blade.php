@extends('layouts.main')
@section('title', 'Threshold Poin Per Siswa')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Threshold & Status Poin Per Siswa</h4>
                        <small class="text-muted">Rule-based: sistem otomatis menentukan status siswa berdasarkan threshold yang diset</small>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        {{-- Keterangan --}}
                        <div class="alert alert-info mb-4">
                            <strong>Keterangan Status:</strong>
                            <span class="badge badge-success ml-2">Sangat Baik</span>
                            <span class="badge badge-primary ml-1">Baik</span>
                            <span class="badge badge-warning ml-1">Cukup</span>
                            <span class="badge ml-1" style="background:#fd7e14;color:#fff;">Kurang</span>
                            <span class="badge badge-danger ml-1">Perlu Perhatian</span>
                            <span class="ml-2 text-muted">| <i class="fas fa-info-circle"></i> Threshold default: 90 / 75 / 60 / 40</span>
                        </div>

                        {{-- Filter --}}
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="kelas_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th class="text-center">Total Poin</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Threshold</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $item['siswa']->nama }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item['siswa']->nis }}</small>
                                        </td>
                                        <td>{{ $item['siswa']->kelas->nama_kelas ?? '-' }}</td>
                                        <td class="text-center">
                                            <strong>{{ $item['total_poin'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $item['status']['color'] }}"
                                                  style="font-size:13px;padding:5px 10px;">
                                                {{ $item['status']['icon'] }} {{ $item['status']['label'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($item['siswa']->thresholdPoin)
                                                <small>
                                                    <span class="badge badge-success">{{ $item['threshold']->sangat_baik }}</span>
                                                    <span class="badge badge-primary">{{ $item['threshold']->baik }}</span>
                                                    <span class="badge badge-warning">{{ $item['threshold']->cukup }}</span>
                                                    <span class="badge" style="background:#fd7e14;color:#fff;">{{ $item['threshold']->kurang }}</span>
                                                </small>
                                                <br>
                                                <small class="text-muted">Custom</small>
                                            @else
                                                <small class="text-muted">Default (90/75/60/40)</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(Auth::user()->roles === 'admin')
                                                <a href="{{ route('admin.threshold.siswa.edit', $item['siswa']->id) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Set
                                                </a>
                                                @if($item['siswa']->thresholdPoin)
                                                <form action="{{ route('admin.threshold.siswa.reset', $item['siswa']->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-secondary btn-sm"
                                                            onclick="return confirm('Reset ke default?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            @else
                                                <a href="{{ route('guru.threshold.siswa.edit', $item['siswa']->id) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Set
                                                </a>
                                                @if($item['siswa']->thresholdPoin)
                                                <form action="{{ route('guru.threshold.siswa.reset', $item['siswa']->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-secondary btn-sm"
                                                            onclick="return confirm('Reset ke default?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data siswa</td>
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