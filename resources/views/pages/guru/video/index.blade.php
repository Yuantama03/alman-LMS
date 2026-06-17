@extends('layouts.main')
@section('title', 'Video Pembelajaran')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Video Pembelajaran</h4>
                        <a href="{{ route('guru.video.section.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Section
                        </a>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        @if($sections->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada video pembelajaran.</p>
                                <a href="{{ route('guru.video.section.create') }}" class="btn btn-primary">
                                    Buat Section Pertama
                                </a>
                            </div>
                        @else
                            @foreach($sections as $section)
                            <div class="card border mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center" style="background:#f8f9fa;">
                                    <div>
                                        <h5 class="mb-0">{{ $section->judul }}</h5>
                                        <small class="text-muted">
                                            {{ $section->videos->count() }} video
                                            @if($section->mapel) · {{ $section->mapel->nama_mapel }} @endif
                                            @if($section->deskripsi) · {{ $section->deskripsi }} @endif
                                        </small>
                                    </div>
                                    <div>
                                        <a href="{{ route('guru.video.create', $section->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-plus"></i> Tambah Video
                                        </a>
                                        <a href="{{ route('guru.video.section.edit', $section->id) }}" class="btn btn-warning btn-sm ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('guru.video.section.destroy', $section->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus section dan semua videonya?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($section->videos->isNotEmpty())
                                <div class="card-body p-0">
                                    <table class="table table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Judul Video</th>
                                                <th>Durasi</th>
                                                <th>URL</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($section->videos as $video)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $video->judul }}</td>
                                                <td>{{ $video->durasi ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ $video->youtube_url }}" target="_blank" class="text-primary">
                                                        <i class="fab fa-youtube"></i> Lihat
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    {{-- TOMBOL DISKUSI DIPINDAH KE SINI AGAR BERFUNGSI PER VIDEO --}}
                                                    <a href="{{ route('guru.video.diskusi', $video->id) }}" class="btn btn-info btn-sm" title="Diskusi">
                                                        <i class="fas fa-comments"></i> Forum Diskusi
                                                    </a>
                                                    
                                                    <a href="{{ route('guru.video.edit', $video->id) }}" class="btn btn-warning btn-sm ml-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('guru.video.destroy', $video->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus video ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection