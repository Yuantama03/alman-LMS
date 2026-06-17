@extends('layouts.main')
@section('title', 'Pengaturan Threshold Poin')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pengaturan Threshold Poin Per Kelas</h4>
                        <small class="text-muted">Atur batas nilai poin untuk menentukan status siswa di setiap kelas</small>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Keterangan Status:</strong>
                                    <span class="badge badge-success ml-2">Sangat Baik</span> Poin ≥ threshold sangat baik &nbsp;|&nbsp;
                                    <span class="badge badge-primary">Baik</span> Poin ≥ threshold baik &nbsp;|&nbsp;
                                    <span class="badge badge-warning">Cukup</span> Poin ≥ threshold cukup &nbsp;|&nbsp;
                                    <span class="badge" style="background:#fd7e14;color:#fff;">Kurang</span> Poin ≥ threshold kurang &nbsp;|&nbsp;
                                    <span class="badge badge-danger">Perlu Perhatian</span> Poin di bawah threshold kurang
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th class="text-center text-success">Sangat Baik (≥)</th>
                                        <th class="text-center text-primary">Baik (≥)</th>
                                        <th class="text-center text-warning">Cukup (≥)</th>
                                        <th class="text-center" style="color:#fd7e14;">Kurang (≥)</th>
                                        <th class="text-center text-danger">Perlu Perhatian (&lt;)</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kelasList as $kelas)
                                    <tr>
                                        <td><strong>{{ $kelas->nama_kelas }}</strong></td>
                                        <td class="text-center">
                                            <span class="badge badge-success">{{ $kelas->thresholdPoin->sangat_baik }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $kelas->thresholdPoin->baik }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-warning">{{ $kelas->thresholdPoin->cukup }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge" style="background:#fd7e14;color:#fff;">{{ $kelas->thresholdPoin->kurang }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-danger">&lt; {{ $kelas->thresholdPoin->kurang }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.threshold.edit', $kelas->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
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