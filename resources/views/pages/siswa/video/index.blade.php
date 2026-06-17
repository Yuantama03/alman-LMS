@extends('layouts.main')
@section('title', 'Video Pembelajaran')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        @if($sections->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada video pembelajaran tersedia.</p>
                </div>
            </div>
        @else
        <div class="row">
            {{-- Video Player --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-0">
                        @if($activeVideo)
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe id="main-player"
                                    class="embed-responsive-item"
                                    src="{{ $activeVideo->embed_url }}"
                                    allowfullscreen
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
            </div>

            {{-- Sidebar: Daftar Section & Video --}}
            <div class="col-md-4">
                <div class="card" style="max-height:600px;overflow-y:auto;">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Video</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($sections as $section)
                        <div class="section-item">
                            {{-- Section Header --}}
                            <div class="px-3 py-2 d-flex justify-content-between align-items-center"
                                 style="background:#f8f9fa;border-bottom:1px solid #dee2e6;cursor:pointer;"
                                 onclick="toggleSection('section-{{ $section->id }}')">
                                <div>
                                    <strong>{{ $section->judul }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $section->videos->count() }} video
                                        @if($section->mapel) · {{ $section->mapel->nama_mapel }} @endif
                                    </small>
                                </div>
                                <i class="fas fa-chevron-down" id="icon-section-{{ $section->id }}"></i>
                            </div>

                            {{-- Video List --}}
                            <div id="section-{{ $section->id }}">
                                @foreach($section->videos as $video)
                                <div class="px-3 py-2 video-item d-flex align-items-center
                                            {{ isset($activeVideo) && $activeVideo->id === $video->id ? 'bg-primary text-white' : '' }}"
                                     style="border-bottom:1px solid #f0f0f0;cursor:pointer;"
                                     onclick="playVideo('{{ $video->embed_url }}', '{{ $video->judul }}', this)">
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
                                </div>
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
function playVideo(embedUrl, title, el) {
    document.getElementById('main-player').src = embedUrl;
    document.getElementById('video-title').textContent = title;

    // Reset semua highlight
    document.querySelectorAll('.video-item').forEach(function(item) {
        item.classList.remove('bg-primary', 'text-white');
    });

    // Highlight yang dipilih
    el.classList.add('bg-primary', 'text-white');
}

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
</script>
@endsection