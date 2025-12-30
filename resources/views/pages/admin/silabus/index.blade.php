@extends('layouts.main')
@section('title', 'List Silabus')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Silabus</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Silabus</button>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Semester</th>
                                            <th>Alokasi Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($silabus as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->mapel->nama_mapel }}</td>
                                                <td>{{ $data->kelas->nama_kelas }}</td>
                                                <td>{{ $data->semester->nama_semester }} - {{ $data->semester->tahun_ajaran }}</td>
                                                <td>{{ $data->alokasi_waktu ? $data->alokasi_waktu . ' menit' : '-' }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('silabus.edit', $data->id) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                        <form method="POST" action="{{ route('silabus.destroy', $data->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Silabus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('silabus.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible show fade">
                                                    <div class="alert-body">
                                                        <button class="close" data-dismiss="alert">
                                                        <span>&times;</span>
                                                        </button>
                                                        @foreach ($errors->all() as $error )
                                                            {{ $error }}
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mapel_id">Mata Pelajaran</label>
                                                        <select id="mapel_id" name="mapel_id" class="select2 form-control @error('mapel_id') is-invalid @enderror">
                                                            <option value="">-- Pilih Mata Pelajaran --</option>
                                                            @foreach ($mapels as $mapel)
                                                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kelas_id">Kelas</label>
                                                        <select id="kelas_id" name="kelas_id" class="select2 form-control @error('kelas_id') is-invalid @enderror">
                                                            <option value="">-- Pilih Kelas --</option>
                                                            @foreach ($kelas as $k)
                                                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="semester_id">Semester</label>
                                                        <select id="semester_id" name="semester_id" class="select2 form-control @error('semester_id') is-invalid @enderror">
                                                            <option value="">-- Pilih Semester --</option>
                                                            @foreach ($semesters as $semester)
                                                                <option value="{{ $semester->id }}">{{ $semester->nama_semester }} - {{ $semester->tahun_ajaran }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="alokasi_waktu">Alokasi Waktu (menit)</label>
                                                        <input type="number" id="alokasi_waktu" name="alokasi_waktu" class="form-control @error('alokasi_waktu') is-invalid @enderror" placeholder="90">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="2" placeholder="Deskripsi silabus"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="kompetensi_dasar">Kompetensi Dasar</label>
                                                <textarea id="kompetensi_dasar" name="kompetensi_dasar" class="form-control @error('kompetensi_dasar') is-invalid @enderror" rows="2" placeholder="Kompetensi dasar yang harus dicapai"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="tujuan_pembelajaran">Tujuan Pembelajaran</label>
                                                <textarea id="tujuan_pembelajaran" name="tujuan_pembelajaran" class="form-control @error('tujuan_pembelajaran') is-invalid @enderror" rows="2" placeholder="Tujuan pembelajaran"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="materi_pokok">Materi Pokok</label>
                                                <textarea id="materi_pokok" name="materi_pokok" class="form-control @error('materi_pokok') is-invalid @enderror" rows="2" placeholder="Materi pokok yang akan diajarkan"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="metode_pembelajaran">Metode Pembelajaran</label>
                                                <textarea id="metode_pembelajaran" name="metode_pembelajaran" class="form-control @error('metode_pembelajaran') is-invalid @enderror" rows="2" placeholder="Metode yang digunakan dalam pembelajaran"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-whitesmoke br">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </section>
@endsection

@push('script')
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Yakin ingin menghapus data ini?`,
                text: "Data akan terhapus secara permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                form.submit();
                }
            });
        });
    </script>
@endpush
