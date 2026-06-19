@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        @if ($siswa->foto != null)
                        <img alt="image" src="{{ url(Storage::url($siswa->foto)) }}" class="rounded-circle profile-widget-picture">
                        @else
                        <img alt="image" src="https://via.placeholder.com/300" class="rounded-circle profile-widget-picture">
                        @endif
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">NIP</div>
                                <div class="profile-widget-item-value">{{ $siswa->nis }}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Telp</div>
                                <div class="profile-widget-item-value">{{ $siswa->telp }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description pb-0">
                        <div class="profile-widget-name">{{ $siswa->nama }}
                            <div class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> siswa {{ $siswa->kelas->nama_kelas }}
                            </div>
                        </div>
                        <label for="alamat">Alamat</label>
                        <p>{{ $siswa->alamat }}</p>
                    </div>
                </div>
                {{-- Indikator Poin --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">{{ $statusPoin['icon'] }} Status Poin Kamu</h5>
                                <small class="text-muted">Total Poin: <strong>{{ $totalPoin }}</strong></small>
                            </div>
                            <span class="badge badge-{{ $statusPoin['color'] }}" style="font-size:14px;padding:6px 14px;">
                                {{ $statusPoin['label'] }}
                            </span>
                        </div>
                        <div class="progress" style="height:10px;">
                            <div class="progress-bar bg-{{ $statusPoin['color'] }}"
                                 role="progressbar" style="width: {{ $persenPoin }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">{{ $thresholdPoin->cukup }}</small>
                            <small class="text-muted">{{ $thresholdPoin->baik }}</small>
                            <small class="text-muted">{{ $thresholdPoin->sangat_baik }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>

            {{-- Rekomendasi Belajar --}}
            <div class="col-12 col-sm-12 col-lg-7">
                <div class="card" style="height:100%;">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-warning text-white mr-2"
                                 style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">Rekomendasi Belajar</h4>
                                <small class="text-muted">Mapel yang perlu lebih diperhatikan (di bawah KKM 75)</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="max-height:280px;overflow-y:auto;">
                        @if($rekomendasiMapel->isNotEmpty())
                            @foreach($rekomendasiMapel as $rekom)
                            <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded"
                                 style="background:#f8f9fa;border-left:4px solid #dc3545;">
                                <div>
                                    <h6 class="mb-1">{{ $rekom['nama_mapel'] }}</h6>
                                    <small class="text-muted">
                                        Rata-rata:
                                        <span class="badge badge-danger">{{ $rekom['rata_rata'] }}</span>
                                        · dari {{ $rekom['jumlah_nilai'] }} tugas
                                    </small>
                                </div>
                                @if($rekom['video_section_id'])
                                <a href="{{ route('siswa.video.index') }}#section-{{ $rekom['video_section_id'] }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-play-circle"></i> Tonton
                                </a>
                                @endif
                            </div>
                            @endforeach
                        @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">Mantap! Semua nilai kamu sudah di atas KKM 🎉</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
                        {{-- Early Warning & SP Status --}}
            <div class="col-12">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-info text-white mr-2"
                                 style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">Status Surat Peringatan</h4>
                                <small class="text-muted">Pantau status peringatan akademik kamu</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- SP Status Table --}}
                            <div class="col-12 col-md-6">
                                <table class="table table-sm table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $spLevels = ['SP 1', 'SP 2', 'SP 3'];
                                        @endphp
                                        
                                        @foreach($spLevels as $level)
                                            @php
                                                $sp = $spAktif->where('level_sp', $level)->first();
                                            @endphp
                                            <tr>
                                                <td><strong>{{ $level }}</strong></td>
                                                <td>
                                                    @if($sp)
                                                        {{ $sp->tanggal_sp->format('d/m/Y') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($sp)
                                                        <span class="badge badge-success">{{ $sp->status }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">Belum Ada</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Early Warning Legend --}}
                                                        <div class="p-3 rounded" style="background:#f8f9fa;">
                                <h6 class="mb-3"><strong>Panduan Early Warning</strong></h6>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="display:inline-block;width:20px;height:20px;background:#28a745;border-radius:50%;margin-right:10px;"></span>
                                        <small><strong>HIJAU (0-24)</strong> - Baik</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="display:inline-block;width:20px;height:20px;background:#ffc107;border-radius:50%;margin-right:10px;"></span>
                                        <small><strong>KUNING (25-49)</strong> - Waspada</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="display:inline-block;width:20px;height:20px;background:#fd7e14;border-radius:50%;margin-right:10px;"></span>
                                        <small><strong>ORANGE (50-74)</strong> - Pembinaan (SP 1)</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="display:inline-block;width:20px;height:20px;background:#dc3545;border-radius:50%;margin-right:10px;"></span>
                                        <small><strong>MERAH (75-99)</strong> - Pembinaan Intensif (SP 2)</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span style="display:inline-block;width:20px;height:20px;background:#343a40;border-radius:50%;margin-right:10px;"></span>
                                        <small><strong>HITAM (100)</strong> - Pengembalian Siswa (SP 3)</small>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-3 mb-0" style="font-size:12px;">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Info:</strong> Poin otomatis meningkat ketika kamu melanggar tata tertib. 
                                    Poin akan direset sesuai kebijakan sekolah.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-3">
                <div class="card card-hero" style="margin-top: 36px">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h4>Pengumuman</h4>
                        <div class="card-description">Pengumuman sekolah hari ini</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                @forelse ($pengumumans as $pengumuman)
                                <div class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>{{ $pengumuman->description }}</h4>
                                    </div>
                                </div>
                                @empty
                                <div class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>Tidak ada pengumuman hari ini</h4>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-3">
                <div class="card card-hero" style="margin-top: 36px">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <h4>Jadwal Mapel</h4>
                        <div class="card-description">Jadwal Mapel hari ini</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                @foreach ($jadwal as $data )
                                @if($data->hari == $hari)
                                <div class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>{{ $data->kelas->nama_kelas }}</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div class="text-primary">Pada jam {{ $data->dari_jam }}</div>
                                    </div>
                                </div>
                                @else
                                <div class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>Tidak ada jadwal hari ini</h4>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-3">
                <div class="card card-hero" style="margin-top: 36px">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4>{{ $materi->count() }}</h4>
                        <div class="card-description">Materi Tersedia</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            @foreach ($materi as $data )
                            @if($data->count() > 0)
                            <div class="ticket-item">
                                <div class="ticket-title">
                                    <h4>{{ $data->judul }}</h4>
                                </div>
                                <div class="ticket-info">
                                    <div>{{ $data->guru->nama }}</div>
                                    <div class="bullet"></div>
                                    <div class="text-primary">{{ $data->guru->mapel->nama_mapel }}</div>
                                </div>
                            </div>
                            <a href="{{ route('siswa.materi') }}" class="ticket-item ticket-more">
                                Lihat Semua <i class="fas fa-chevron-right"></i>
                            </a>
                            @else
                            <div class="ticket-item">
                                <div class="ticket-title">
                                    <h4>Tidak ada materi tersedia</h4>
                                </div>
                            </div>

                            @endif

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-3">
                <div class="card card-hero" style="margin-top: 36px">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4>{{ $tugas->count() }}</h4>
                        <div class="card-description">Tugas Tersedia</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            @foreach ($tugas as $data )
                            @if ($data->count() > 0)
                            <div class="ticket-item">
                                <div class="ticket-title">
                                    <h4>{{ $data->judul }}</h4>
                                </div>
                                <div class="ticket-info">
                                    <div>{{ $data->guru->nama }}</div>
                                    <div class="bullet"></div>
                                    <div class="text-primary">{{ $data->guru->mapel->nama_mapel }}</div>
                                </div>
                            </div>
                            <a href="{{ route('siswa.materi') }}" class="ticket-item ticket-more">
                                Lihat Semua <i class="fas fa-chevron-right"></i>
                            </a>

                            @else
                            <div class="ticket-item">
                                <div class="ticket-title">
                                    <h4>Tidak ada tugas</h4>
                                </div>
                            </div>
                            @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>
       

    </div>
</section>
@endsection