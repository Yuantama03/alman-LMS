@extends('layouts.main')
@section('title', 'Video Pembelajaran')

@section('content')
<section class="section custom-section">
    <div class="section-body">

        <div class="card">
            <div class="card-body">
                <form action="{{ route('siswa.video.index') }}" method="GET" class="form-inline">
                    <div class="input-group" style="flex:1;">
                        <input type="text" name="q" class="form-control"
                               placeholder="Cari video, section, atau mapel..."
                               value="{{ $keyword ?? '' }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(!empty($keyword))
                            <a href="{{ route('siswa.video.index') }}" class="btn btn-secondary">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($sections->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                    <p class="text-muted">
                        @if(!empty($keyword))
                            Tidak ada video yang cocok dengan pencarian "{{ $keyword }}".
                        @else
                            Belum ada video pembelajaran tersedia.
                        @endif
                    </p>
                </div>
            </div>
        @else
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-0">
                        @if($activeVideo)
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe id="main-player" class="embed-responsive-item"
                                    src="{{ $activeVideo->embed_url }}" allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        </div>
                        <div class="p-3">
                            <h5 id="video-title">{{ $activeVideo->judul }}</h5>
                            <small class="text-muted">
                                {{ $activeVideo->section->judul }}
                                @if($activeVideo->durasi) · {{ $activeVideo->durasi }} @endif
                                @if($activeVideo->section->mapel) · {{ $activeVideo->section->mapel->nama_mapel }} @endif
                            </small>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-play-circle fa-3x text-muted"></i>
                            <p class="text-muted mt-2">Pilih video untuk ditonton</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($activeVideo)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-comments"></i> Diskusi
                            <span class="badge badge-secondary">{{ $activeVideo->comments->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        <form action="{{ route('video.komentar.store', $activeVideo->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="isi" class="form-control" rows="2"
                                          placeholder="Tulis pertanyaan atau komentarmu..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </form>

                        @forelse($activeVideo->comments as $comment)
                            @include('partials.video-comment', ['comment' => $comment, 'video' => $activeVideo])
                        @empty
                            <p class="text-muted text-center mb-0">Belum ada diskusi. Jadilah yang pertama bertanya!</p>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                @if(isset($recommended) && $recommended->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-star text-warning"></i> Rekomendasi Untukmu</h5>
                        <small class="text-muted">Berdasarkan mapel yang sering kamu tonton</small>
                    </div>
                    <div class="card-body p-0">
                        @foreach($recommended as $rec)
                        <a href="{{ route('siswa.video.play', $rec->id) }}"
                           class="d-flex align-items-center px-3 py-2 text-dark"
                           style="border-bottom:1px solid #f0f0f0;text-decoration:none;">
                            <div class="mr-3">
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width:40px;height:40px;background:#e9ecef;">
                                    <i class="fas fa-play text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:500;">{{ $rec->judul }}</div>
                                <small class="text-muted">
                                    @if($rec->section->mapel) {{ $rec->section->mapel->nama_mapel }} · @endif
                                    {{ $rec->views_count }}x ditonton
                                </small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="card" style="max-height:600px;overflow-y:auto;">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Video</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($sections as $section)
                        <div class="section-item">
                            <div class="px-3 py-2 d-flex justify-content-between align-items-center"
                                 style="background:#f8f9fa;border-bottom:1px solid #dee2e6;cursor:pointer;"
                                 onclick="toggleSection('section-{{ $section->id }}')">
                                <div>
                                    <strong>{{ $section->judul }}</strong><br>
                                    <small class="text-muted">
                                        {{ $section->videos->count() }} video
                                        @if($section->mapel) · {{ $section->mapel->nama_mapel }} @endif
                                    </small>
                                </div>
                                <i class="fas fa-chevron-down" id="icon-section-{{ $section->id }}"></i>
                            </div>

                            <div id="section-{{ $section->id }}">
                                @foreach($section->videos as $video)
                                <a href="{{ route('siswa.video.play', $video->id) }}"
                                   class="px-3 py-2 video-item d-flex align-items-center text-dark
                                          {{ isset($activeVideo) && $activeVideo->id === $video->id ? 'bg-primary text-white' : '' }}"
                                   style="border-bottom:1px solid #f0f0f0;text-decoration:none;">
                                    <div class="mr-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;background:{{ isset($activeVideo) && $activeVideo->id === $video->id ? 'rgba(255,255,255,0.3)' : '#e9ecef' }}">
                                            <i class="fas fa-play" style="font-size:10px;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="font-size:13px;font-weight:500;">{{ $video->judul }}</div>
                                        @if($video->durasi)
                                        <small style="opacity:0.7;">{{ $video->durasi }}</small>
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<script>
function toggleSection(id) {
    const el   = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    if (el.style.display === 'none') {
        el.style.display = 'block';
        icon.classList.replace('fa-chevron-right', 'fa-chevron-down');
    } else {
        el.style.display = 'none';
        icon.classList.replace('fa-chevron-down', 'fa-chevron-right');
    }
}

function toggleReplyForm(id) {
    const el = document.getElementById('reply-form-' + id);
    if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection