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
    
    .activity-item {
        padding: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .activity-item:last-child {
        border-bottom: none;
    }
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .activity-icon.prestasi {
        background-color: #d4edda;
        color: #155724;
    }
    .activity-icon.pelanggaran {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <!-- Basic Stats -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Siswa</h4>
                            </div>
                            <div class="card-body">
                                {{ $siswa }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Mata Pelajaran</h4>
                            </div>
                            <div class="card-body">
                                {{ $mapel }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Guru</h4>
                            </div>
                            <div class="card-body">
                                {{ $guru }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Kelas</h4>
                            </div>
                            <div class="card-body">
                                {{ $kelas }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presensi Stats Today -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Presensi Hari Ini</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card info-box info-success p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0 text-muted">Hadir</h6>
                                                <h3 class="mb-0">{{ $presensiHadir }}</h3>
                                            </div>
                                            <div>
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card info-box info-warning p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0 text-muted">Sakit</h6>
                                                <h3 class="mb-0">{{ $presensiSakit }}</h3>
                                            </div>
                                            <div>
                                                <i class="fas fa-user-injured fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card info-box info-primary p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0 text-muted">Izin</h6>
                                                <h3 class="mb-0">{{ $presensiIzin }}</h3>
                                            </div>
                                            <div>
                                                <i class="fas fa-envelope fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card info-box info-danger p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0 text-muted">Alpha</h6>
                                                <h3 class="mb-0">{{ $presensiAlpha }}</h3>
                                            </div>
                                            <div>
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Poin & Tugas Stats -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Poin Siswa</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6 class="text-muted">Total Poin</h6>
                                        <h3 class="text-primary">{{ number_format($totalPoin) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6 class="text-muted">Prestasi</h6>
                                        <h3 class="text-success">+{{ number_format($totalPrestasi) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6 class="text-muted">Pelanggaran</h6>
                                        <h3 class="text-danger">-{{ number_format($totalPelanggaran) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <canvas id="poinChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Tugas</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6 class="text-muted">Total Tugas</h6>
                                        <h3>{{ $totalTugas }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6 class="text-muted">Tugas Aktif</h6>
                                        <h3 class="text-primary">{{ $tugasAktif }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6 class="text-muted">Tingkat Pengumpulan</h6>
                                        <h3 class="text-success">{{ $submissionRate }}%</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $submissionRate }}%;" aria-valuenow="{{ $submissionRate }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $submissionRate }}%
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0 text-center">
                                {{ $totalJawaban }} dari {{ $totalTugas * $siswa }} tugas dikumpulkan
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Students & Recent Activities -->
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
                                            <th>Kelas</th>
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
                                            <td>{{ $siswaTop->kelas->nama_kelas ?? '-' }}</td>
                                            <td class="text-right">
                                                <span class="badge badge-{{ $siswaTop->poin_siswa_sum_poin >= 0 ? 'success' : 'danger' }}">
                                                    {{ number_format($siswaTop->poin_siswa_sum_poin ?? 0) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada data poin</td>
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
                            <h4>Aktivitas Terbaru (Poin)</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                                @forelse($recentActivities as $activity)
                                <div class="list-group-item activity-item">
                                    <div class="d-flex">
                                        <div class="activity-icon {{ strtolower($activity->jenis) }} mr-3">
                                            <i class="fas fa-{{ $activity->jenis == 'Prestasi' ? 'trophy' : 'exclamation-triangle' }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $activity->siswa->nama ?? 'N/A' }}</h6>
                                            <p class="mb-0 text-muted small">{{ $activity->kategori }} - {{ $activity->deskripsi }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-user"></i> {{ $activity->creator->name ?? 'System' }} • 
                                                <i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="text-right">
                                            <span class="badge badge-{{ $activity->jenis == 'Prestasi' ? 'success' : 'danger' }}">
                                                {{ $activity->poin > 0 ? '+' : '' }}{{ $activity->poin }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="list-group-item text-center">
                                    <p class="mb-0 text-muted">Belum ada aktivitas</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tren Pendaftaran Siswa (6 Bulan Terakhir)</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="enrollmentChart" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tren Presensi (7 Hari Terakhir)</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="attendanceChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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

    // Enrollment Chart (Line)
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(enrollmentCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($monthlyEnrollment, 'month')) !!},
            datasets: [{
                label: 'Siswa Baru',
                data: {!! json_encode(array_column($monthlyEnrollment, 'count')) !!},
                borderColor: '#6777ef',
                backgroundColor: 'rgba(103, 119, 239, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
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
                    beginAtZero: true
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
@endpush
