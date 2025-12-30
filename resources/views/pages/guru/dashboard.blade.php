@extends('layouts.main')
@section('title', 'Dashboard')

@push('styles')
<style>
    .info-box {
        display: flex;
        flex-direction: column;
        border-left: 3px solid;
    }
    .info-box.info-primary { border-left-color: #6777ef; }
    .info-box.info-success { border-left-color: #28a745; }
    .info-box.info-danger { border-left-color: #dc3545; }
    .info-box.info-warning { border-left-color: #ffc107; }
    
    .student-alert-item {
        padding: 10px;
        border-left: 3px solid #dc3545;
        margin-bottom: 10px;
        background-color: #fff5f5;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Selamat datang pak/bu {{ Auth::user()->name }}</h1>
    </div>

    <div class="section-body">
        <!-- Basic Stats -->
        <div class="row">
            {{-- Jadwal --}}
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card card-hero">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4>Jadwal Mengajar</h4>
                        <div class="card-description">Berikut list jadwal kelas tempat mengajar anda</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            @php $hasScheduleToday = false; @endphp
                            @foreach ($jadwal as $data)
                                @if($data->hari == $hari)
                                    @php $hasScheduleToday = true; @endphp
                                    <div class="ticket-item">
                                        <div class="ticket-title">
                                            <h4>{{ $data->kelas->nama_kelas }}</h4>
                                        </div>
                                        <div class="ticket-info">
                                            <div class="text-primary">Pada jam {{ $data->dari_jam }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if(!$hasScheduleToday)
                                <div class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>Tidak ada jadwal mengajar hari ini</h4>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Materi Diajarkan</h4>
                        </div>
                        <div class="card-body">
                            {{ $materi }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Tugas diberikan</h4>
                        </div>
                        <div class="card-body">
                            {{ $tugas }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($kelas)
        <!-- Wali Kelas Analytics -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Analitik Kelas {{ $kelas->nama_kelas }}</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">Wali Kelas</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Class Overview -->
                        <div class="row p-3">
                            <div class="col-lg-3 col-md-6">
                                <div class="card info-box info-primary p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted">Total Siswa</h6>
                                            <h3 class="mb-0">{{ $totalSiswa }}</h3>
                                        </div>
                                        <div>
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card info-box info-success p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted">Kehadiran (7 Hari)</h6>
                                            <h3 class="mb-0">{{ $attendancePercentage }}%</h3>
                                        </div>
                                        <div>
                                            <i class="fas fa-chart-line fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card info-box info-warning p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted">Tugas Kelas</h6>
                                            <h3 class="mb-0">{{ $tugasKelas }}</h3>
                                        </div>
                                        <div>
                                            <i class="fas fa-tasks fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card info-box info-danger p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted">Tingkat Pengumpulan</h6>
                                            <h3 class="mb-0">{{ $submissionRate }}%</h3>
                                        </div>
                                        <div>
                                            <i class="fas fa-clipboard-check fa-2x text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Presensi Today -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Presensi Hari Ini - {{ $kelas->nama_kelas }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="text-center p-3 border-right">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <h6 class="text-muted">Hadir</h6>
                                    <h3>{{ $presensiHadir }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-center p-3 border-right">
                                    <i class="fas fa-user-injured fa-2x text-warning mb-2"></i>
                                    <h6 class="text-muted">Sakit</h6>
                                    <h3>{{ $presensiSakit }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-center p-3 border-right">
                                    <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                    <h6 class="text-muted">Izin</h6>
                                    <h3>{{ $presensiIzin }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-center p-3">
                                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                    <h6 class="text-muted">Alpha</h6>
                                    <h3>{{ $presensiAlpha }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analysis -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Distribusi Poin Kelas</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6 text-center">
                                <h6 class="text-muted">Prestasi</h6>
                                <h3 class="text-success">+{{ number_format($totalPrestasi) }}</h3>
                            </div>
                            <div class="col-6 text-center">
                                <h6 class="text-muted">Pelanggaran</h6>
                                <h3 class="text-danger">-{{ number_format($totalPelanggaran) }}</h3>
                            </div>
                        </div>
                        <canvas id="poinChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Tren Presensi (7 Hari Terakhir)</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Students & Alerts -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Top 5 Siswa Berdasarkan Poin</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Nama</th>
                                        <th class="text-right">Total Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topSiswa as $index => $siswaTop)
                                    <tr>
                                        <td>
                                            @if($index == 0)
                                                <i class="fas fa-trophy text-warning"></i> #{{ $index + 1 }}
                                            @elseif($index == 1)
                                                <i class="fas fa-medal text-secondary"></i> #{{ $index + 1 }}
                                            @elseif($index == 2)
                                                <i class="fas fa-medal text-danger"></i> #{{ $index + 1 }}
                                            @else
                                                #{{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>{{ $siswaTop->nama }}</td>
                                        <td class="text-right">
                                            <span class="badge badge-{{ $siswaTop->poin_siswa_sum_poin >= 0 ? 'success' : 'danger' }}">
                                                {{ number_format($siswaTop->poin_siswa_sum_poin ?? 0) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data poin</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Siswa Memerlukan Perhatian</h4>
                        <div class="card-header-action">
                            <span class="badge badge-warning">{{ $studentsNeedingAttention->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($studentsNeedingAttention as $siswa)
                            @php
                                $weekAgo = now()->subDays(7)->format('Y-m-d');
                                $hadirCount = \App\Models\Presensi::where('siswa_id', $siswa->id)
                                    ->where('kelas_id', $kelas->id)
                                    ->whereDate('tanggal', '>=', $weekAgo)
                                    ->where('status', 'Hadir')
                                    ->count();
                                $attendanceRate = round(($hadirCount / 7) * 100, 1);
                                $poin = $siswa->poin_siswa_sum_poin ?? 0;
                            @endphp
                            <div class="student-alert-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $siswa->nama }}</h6>
                                        <small class="text-muted">
                                            @if($attendanceRate < 70)
                                                <i class="fas fa-exclamation-circle text-danger"></i> Kehadiran rendah: {{ $attendanceRate }}%
                                            @endif
                                            @if($poin < 0)
                                                <i class="fas fa-exclamation-triangle text-warning"></i> Poin negatif: {{ $poin }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-{{ $poin >= 0 ? 'success' : 'danger' }}">
                                            Poin: {{ $poin }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-check-circle fa-3x mb-2"></i>
                                <p>Semua siswa dalam kondisi baik!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- No Class Assigned -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Anda belum ditugaskan sebagai wali kelas. Analitik kelas tidak tersedia.
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
@if($kelas)
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Poin Chart (Doughnut)
    const poinCtx = document.getElementById('poinChart').getContext('2d');
    new Chart(poinCtx, {
        type: 'doughnut',
        data: {
            labels: ['Prestasi', 'Pelanggaran'],
            datasets: [{
                data: [{{ $totalPrestasi }}, {{ $totalPelanggaran }}],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Attendance Trend Chart (Stacked Bar)
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($attendanceTrend, 'date')) !!},
            datasets: [
                {
                    label: 'Hadir',
                    data: {!! json_encode(array_column($attendanceTrend, 'hadir')) !!},
                    backgroundColor: '#28a745'
                },
                {
                    label: 'Sakit',
                    data: {!! json_encode(array_column($attendanceTrend, 'sakit')) !!},
                    backgroundColor: '#ffc107'
                },
                {
                    label: 'Izin',
                    data: {!! json_encode(array_column($attendanceTrend, 'izin')) !!},
                    backgroundColor: '#6777ef'
                },
                {
                    label: 'Alpha',
                    data: {!! json_encode(array_column($attendanceTrend, 'alpha')) !!},
                    backgroundColor: '#dc3545'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endif
@endpush
