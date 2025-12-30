@extends('layouts.main')
@section('title', 'Detail Tugas')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('partials.alert')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Detail Tugas: {{ $tugas->judul }}</h4>
                            <a href="{{ route('admin.tugas.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="200">Guru Pembuat</th>
                                            <td>: {{ $tugas->guru->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kelas</th>
                                            <td>: {{ $tugas->kelas->nama_kelas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Dibuat</th>
                                            <td>: {{ $tugas->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="200">Deskripsi</th>
                                            <td>: {{ $tugas->deskripsi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>File Tugas</th>
                                            <td>: 
                                                @if($tugas->file)
                                                    <a href="{{ route('siswa.tugas.download', $tugas->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <h5 class="mb-3">Daftar Siswa yang Mengumpulkan ({{ $jawaban->count() }} siswa)</h5>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama Siswa</th>
                                            <th>Jawaban</th>
                                            <th>File</th>
                                            <th>Tanggal Upload</th>
                                            <th>Nilai</th>
                                            <th>Komentar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jawaban as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->siswa->nis }}</td>
                                                <td>{{ $data->siswa->nama }}</td>
                                                <td>{{ Str::limit($data->jawaban, 50) }}</td>
                                                <td>
                                                    @if($data->file)
                                                        <a href="{{ route('guru.jawaban.download', $data->id) }}" class="btn btn-sm btn-success">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $data->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($data->nilai)
                                                        <span class="badge badge-success">{{ $data->nilai }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">Belum dinilai</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->komentar ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Belum ada siswa yang mengumpulkan</td>
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
