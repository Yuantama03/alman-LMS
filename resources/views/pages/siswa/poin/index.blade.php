@extends('layouts.main')
@section('title', 'Poin Saya')

@section('content')
    <section class="section custom-section">
        <div class="section-body">

            {{-- Summary Cards --}}
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

            {{-- Status Poin (Rule-Based) --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center justify-content-center mr-3"
                                         style="width:56px;height:56px;border-radius:50%;background:rgba(0,0,0,0.04);font-size:28px;">
                                        {{ $status['icon'] }}
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Status Poin Kamu</h5>
                                        <small class="text-muted">Total Poin: <strong>{{ $totalPoin }}</strong></small>
                                    </div>
                                </div>
                                <span class="badge badge-{{ $status['color'] }}" style="font-size:14px;padding:8px 18px;">
                                    {{ $status['label'] }}
                                </span>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="progress" style="height:10px;border-radius:10px;">
                                <div class="progress-bar bg-{{ $status['color'] }}"
                                     role="progressbar" style="width: {{ $persenPoin }}%; border-radius:10px;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">0</small>
                                <small class="text-muted">{{ $threshold->cukup }}</small>
                                <small class="text-muted">{{ $threshold->baik }}</small>
                                <small class="text-muted">{{ $threshold->sangat_baik }}</small>
                            </div>

                            {{-- Threshold Legend --}}
                            <hr>
                            <small class="text-muted d-block mb-2">Kategori status poin kamu:</small>
                            <div class="d-flex flex-wrap" style="gap:8px;">
                                <span class="badge badge-success" style="padding:6px 12px;">⭐ Sangat Baik ≥ {{ $threshold->sangat_baik }}</span>
                                <span class="badge badge-primary" style="padding:6px 12px;">👍 Baik ≥ {{ $threshold->baik }}</span>
                                <span class="badge badge-warning" style="padding:6px 12px;">📝 Cukup ≥ {{ $threshold->cukup }}</span>
                                <span class="badge badge-danger" style="padding:6px 12px;">⚠️ Kurang &lt; {{ $threshold->cukup }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                {{-- Early Warning (Poin Pelanggaran) --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center justify-content-center mr-3"
                                         style="width:56px;height:56px;border-radius:50%;background:rgba(0,0,0,0.04);font-size:28px;">
                                        {{ $earlyWarningStatus['icon'] }}
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Status Pelanggaran Kamu</h5>
                                        <small class="text-muted">Total Pelanggaran: <strong>{{ $totalPoinPelanggaran }}</strong></small>
                                    </div>
                                </div>
                                <span class="badge badge-{{ $earlyWarningStatus['bootstrap_class'] }}" style="font-size:14px;padding:8px 18px;">
                                    {{ $earlyWarningStatus['label'] }}
                                </span>
                            </div>

                            {{-- Progress Bar Pelanggaran --}}
                            <div class="progress" style="height:10px;border-radius:10px;">
                                <div class="progress-bar bg-{{ $earlyWarningStatus['bootstrap_class'] }}"
                                     role="progressbar" style="width: {{ min(($totalPoinPelanggaran / 100) * 100, 100) }}%; border-radius:10px;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">0</small>
                                <small class="text-muted">25</small>
                                <small class="text-muted">50</small>
                                <small class="text-muted">75</small>
                                <small class="text-muted">100</small>
                            </div>

                            {{-- Early Warning Legend --}}
                            <hr>
                            <small class="text-muted d-block mb-2">Kategori Early Warning Pelanggaran:</small>
                            <div class="d-flex flex-wrap" style="gap:8px;">
                                <span class="badge badge-success" style="padding:6px 12px;">🟢 HIJAU (0-24) - Baik</span>
                                <span class="badge badge-warning" style="padding:6px 12px;">🟡 KUNING (25-49) - Waspada</span>
                                <span class="badge badge-danger" style="padding:6px 12px;">🟠 ORANGE (50-74) - Pembinaan (SP 1)</span>
                                <span class="badge badge-danger" style="padding:6px 12px;">🔴 MERAH (75-99) - Pembinaan Intensif (SP 2)</span>
                                <span class="badge badge-dark" style="padding:6px 12px;">⚫ HITAM (100) - Pengembalian Siswa (SP 3)</span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Poin --}}
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