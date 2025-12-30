@extends('layouts.main')
@section('title', 'List User')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List Tugas</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Tugas</th>
                                        <th>Deskripsi</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Status</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tugas as $key => $tugasItem)
                                    @php
                                        $userJawaban = $jawaban->firstWhere('tugas_id', $tugasItem->id);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tugasItem->judul }}</td>
                                        <td>{{ $tugasItem->deskripsi }}</td>
                                        <td>{{ $tugasItem->guru->mapel->nama_mapel }}</td>
                                        <td>
                                            @if ($userJawaban)
                                                <span class="badge badge-success">Sudah Dikumpulkan</span>
                                            @else
                                                <span class="badge badge-warning">Belum Dikumpulkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($userJawaban && $userJawaban->nilai)
                                                <span class="badge badge-info">{{ $userJawaban->nilai }}</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @if (!$userJawaban)
                                                    <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#kirimModal{{ $tugasItem->id }}">
                                                        <i class="nav-icon fas fa-paper-plane"></i>&nbsp; Kirim Jawaban
                                                    </button>
                                                @else
                                                    <button class="btn btn-info btn-sm mr-2" data-toggle="modal" data-target="#detailModal{{ $tugasItem->id }}">
                                                        <i class="nav-icon fas fa-eye"></i>&nbsp; Lihat Detail
                                                    </button>
                                                @endif
                                                <a href="{{ route('siswa.tugas.download', $tugasItem->id) }}" class="btn btn-success btn-sm">
                                                    <i class="nav-icon fas fa-download"></i> &nbsp; Download Tugas
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Kirim Jawaban -->
                                    <div class="modal fade" id="kirimModal{{ $tugasItem->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Kirim Jawaban - {{ $tugasItem->judul }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('kirim-jawaban') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input name="tugas_id" type="hidden" value="{{ $tugasItem->id }}">
                                                        <div class="form-group">
                                                            <label for="jawaban">Jawaban</label>
                                                            <textarea id="jawaban" name="jawaban" class="form-control @error('jawaban') is-invalid @enderror" rows="4" placeholder="Tulis jawaban Anda di sini" required></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file">File Tugas (Opsional)</label>
                                                            <div class="custom-file">
                                                                <input id="file" type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror">
                                                                <label class="custom-file-label" for="file">Pilih file</label>
                                                            </div>
                                                            <small class="form-text text-muted">Format: PDF, DOC, DOCX, PPT, PPTX, PNG, JPG, JPEG (Max: 2MB)</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Detail Jawaban -->
                                    @if ($userJawaban)
                                    <div class="modal fade" id="detailModal{{ $tugasItem->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Jawaban - {{ $tugasItem->judul }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label><strong>Jawaban Anda:</strong></label>
                                                        <p>{{ $userJawaban->jawaban }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>File:</strong></label>
                                                        <p>
                                                            @if($userJawaban->file)
                                                                <a href="{{ route('guru.jawaban.download', $userJawaban->id) }}" class="btn btn-sm btn-success">
                                                                    <i class="fas fa-download"></i> Download File Anda
                                                                </a>
                                                            @else
                                                                Tidak ada file
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>Tanggal Dikumpulkan:</strong></label>
                                                        <p>{{ $userJawaban->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>Nilai:</strong></label>
                                                        <p>
                                                            @if($userJawaban->nilai)
                                                                <span class="badge badge-success" style="font-size: 16px;">{{ $userJawaban->nilai }}</span>
                                                            @else
                                                                <span class="badge badge-secondary">Belum dinilai</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    @if($userJawaban->komentar)
                                                    <div class="form-group">
                                                        <label><strong>Komentar Guru:</strong></label>
                                                        <p class="alert alert-info">{{ $userJawaban->komentar }}</p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada tugas</td>
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
