@extends('layouts.main')
@section('title', 'List Tugas')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Pengumpulan Tugas {{ $tugas->judul }}</h4>
                            <a class="btn btn-primary btn-sm" href="{{ route('tugas.index') }}">Kembali</a>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Tgl Pengumpulan</th>
                                            <th>Nilai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jawaban as $result => $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->siswa->nama }}</td>
                                                <td>{{ $data->siswa->kelas->nama_kelas }}</td>
                                                <td>{{ date("d-m-Y", strtotime($data->created_at)) ?? '' }}</td>
                                                <td>
                                                    @if($data->nilai)
                                                        <span class="badge badge-success">{{ $data->nilai }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">Belum dinilai</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('guru.jawaban.download', $data->id) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-download"></i> &nbsp; Download</a>
                                                        <button class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#nilaiModal{{ $data->id }}">
                                                            <i class="nav-icon fas fa-edit"></i> &nbsp; {{ $data->nilai ? 'Edit Nilai' : 'Beri Nilai' }}
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Input Nilai -->
                                            <div class="modal fade" id="nilaiModal{{ $data->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Input Nilai - {{ $data->siswa->nama }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('guru.tugas.nilai', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Jawaban Siswa</label>
                                                                    <p class="form-control-static">{{ $data->jawaban }}</p>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nilai">Nilai (0-100)</label>
                                                                    <input type="number" class="form-control @error('nilai') is-invalid @enderror" id="nilai" name="nilai" min="0" max="100" value="{{ $data->nilai ?? old('nilai') }}" required>
                                                                    @error('nilai')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="komentar">Komentar (Opsional)</label>
                                                                    <textarea class="form-control" id="komentar" name="komentar" rows="3">{{ $data->komentar ?? old('komentar') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
