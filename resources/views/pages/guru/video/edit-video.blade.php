@extends('layouts.main')
@section('title', 'Edit Video')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Video — {{ $section->judul }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.video.update', $video->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="form-group">
                                <label>Judul Video <span class="text-danger">*</span></label>
                                <input type="text" name="judul"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       value="{{ old('judul', $video->judul) }}" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label>URL YouTube <span class="text-danger">*</span></label>
                                <input type="url" name="youtube_url" id="youtube_url"
                                       class="form-control @error('youtube_url') is-invalid @enderror"
                                       value="{{ old('youtube_url', $video->youtube_url) }}" required>
                                @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Preview --}}
                            <div class="form-group">
                                <label>Preview</label>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe id="preview-frame" class="embed-responsive-item"
                                            src="{{ $video->embed_url }}" allowfullscreen></iframe>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Durasi</label>
                                <input type="text" name="durasi" class="form-control"
                                       value="{{ old('durasi', $video->durasi) }}"
                                       placeholder="Contoh: 10 menit">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Video
                                </button>
                                <a href="{{ route('guru.video.index') }}" class="btn btn-secondary ml-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('youtube_url').addEventListener('input', function() {
    const url = this.value;
    let videoId = null;
    const match1 = url.match(/youtu\.be\/([a-zA-Z0-9_-]+)/);
    const match2 = url.match(/[?&]v=([a-zA-Z0-9_-]+)/);
    if (match1) videoId = match1[1];
    else if (match2) videoId = match2[1];
    if (videoId) {
        document.getElementById('preview-frame').src = 'https://www.youtube.com/embed/' + videoId;
    }
});
</script>
@endsection