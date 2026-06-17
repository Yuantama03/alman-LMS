@extends('layouts.main')
@section('title', 'Diskusi Video')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Diskusi: {{ $video->judul }}</h4>
                            <small class="text-muted">
                                {{ $video->section->judul }}
                                @if($video->section->mapel) · {{ $video->section->mapel->nama_mapel }} @endif
                            </small>
                        </div>
                        <a href="{{ route('guru.video.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        <form action="{{ route('video.komentar.store', $video->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="isi" class="form-control" rows="2"
                                          placeholder="Tulis komentar atau pengumuman untuk video ini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </form>

                        <hr>

                        @forelse($video->comments as $comment)
                            @include('partials.video-comment', ['comment' => $comment, 'video' => $video])
                        @empty
                            <p class="text-muted text-center mb-0">Belum ada diskusi pada video ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleReplyForm(id) {
    const el = document.getElementById('reply-form-' + id);
    if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection