{{-- Partial komentar video — dipakai di halaman siswa & guru. Variabel: $comment, $video --}}
@php
    $authUser = Auth::user();
    $isGuru   = $authUser && $authUser->roles === 'guru';
    $commenterIsGuru = optional($comment->user)->roles === 'guru';
@endphp

<div class="d-flex mb-3">
    <div class="mr-2">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:36px;height:36px;background:{{ $commenterIsGuru ? '#0d6efd' : '#e9ecef' }};color:{{ $commenterIsGuru ? '#fff' : '#333' }};">
            <i class="fas fa-user" style="font-size:13px;"></i>
        </div>
    </div>
    <div style="flex:1;">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <strong>{{ optional($comment->user)->name ?? 'Pengguna' }}</strong>
                @if($commenterIsGuru)
                    <span class="badge badge-primary">Guru</span>
                @endif
                <small class="text-muted ml-1">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            @if($isGuru || $comment->user_id === optional($authUser)->id)
            <form action="{{ route('video.komentar.destroy', $comment->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm text-danger p-0"
                        onclick="return confirm('Hapus komentar ini?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            @endif
        </div>
        <p class="mb-1">{{ $comment->isi }}</p>

        <button type="button" class="btn btn-link btn-sm p-0" onclick="toggleReplyForm({{ $comment->id }})">
            <i class="fas fa-reply"></i> Balas
        </button>

        <div id="reply-form-{{ $comment->id }}" style="display:none;" class="mt-2">
            <form action="{{ route('video.komentar.store', $video->id) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="input-group">
                    <input type="text" name="isi" class="form-control form-control-sm"
                           placeholder="Tulis balasan..." required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                    </div>
                </div>
            </form>
        </div>

        @if($comment->replies->isNotEmpty())
        <div class="mt-2 pl-3" style="border-left:2px solid #e9ecef;">
            @foreach($comment->replies as $reply)
                @php $replyIsGuru = optional($reply->user)->roles === 'guru'; @endphp
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <strong style="font-size:13px;">{{ optional($reply->user)->name ?? 'Pengguna' }}</strong>
                        @if($replyIsGuru)
                            <span class="badge badge-primary">Guru</span>
                        @endif
                        <small class="text-muted ml-1">{{ $reply->created_at->diffForHumans() }}</small>
                        <div style="font-size:14px;">{{ $reply->isi }}</div>
                    </div>
                    @if($isGuru || $reply->user_id === optional($authUser)->id)
                    <form action="{{ route('video.komentar.destroy', $reply->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-link btn-sm text-danger p-0"
                                onclick="return confirm('Hapus balasan ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>