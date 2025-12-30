@extends('layouts.main')
@section('title', 'List Tugas')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Semua Tugas</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Tugas</th>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Jumlah Siswa Mengumpulkan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugas as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>{{ $data->guru->nama }}</td>
                                                <td>{{ $data->kelas->nama_kelas }}</td>
                                                <td>{{ $data->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge badge-info">{{ $data->jawaban->count() }} siswa</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.tugas.show', $data->id) }}" class="btn btn-info btn-sm">
                                                        <i class="nav-icon fas fa-eye"></i> &nbsp; Detail
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
