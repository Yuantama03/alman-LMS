@extends('layouts.main')
@section('title', $group->nama_grup)

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            {{-- Chat Area --}}
            <div class="col-md-8">
                <div class="card" style="height:600px;display:flex;flex-direction:column;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-users text-primary"></i> {{ $group->nama_grup }}</h4>
                            <small class="text-muted">{{ $group->members->count() }} anggota</small>
                        </div>
                        <a href="{{ route('chat.group.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    {{-- Messages --}}
                    <div class="card-body" id="chat-messages"
                         style="flex:1;overflow-y:auto;background:#f8f9fa;padding:15px;">
                        @forelse($messages as $msg)
                            @if($msg->user_id === Auth::id())
                            {{-- Pesan sendiri (kanan) --}}
                            <div class="d-flex justify-content-end mb-2">
                                <div style="max-width:70%;">
                                    <div class="bg-primary text-white rounded px-3 py-2">
                                        {{ $msg->message }}
                                    </div>
                                    <small class="text-muted d-block text-right">
                                        {{ $msg->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                            @else
                            {{-- Pesan orang lain (kiri) --}}
                            <div class="d-flex justify-content-start mb-2">
                                <div style="max-width:70%;">
                                    <small class="text-muted d-block"><strong>{{ $msg->user->name }}</strong></small>
                                    <div class="bg-white border rounded px-3 py-2">
                                        {{ $msg->message }}
                                    </div>
                                    <small class="text-muted d-block">
                                        {{ $msg->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-comment-slash fa-2x mb-2"></i>
                                <p>Belum ada pesan. Mulai percakapan!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Input --}}
                    @if(Auth::user()->roles !== 'guru')
                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" id="message-input" class="form-control"
                                   placeholder="Ketik pesan..." autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="send-btn">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card-footer text-center text-muted">
                        <i class="fas fa-eye"></i> Anda memantau grup ini
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar: Info Grup --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Info Grup</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama:</strong> {{ $group->nama_grup }}</p>
                        <p><strong>Dibuat oleh:</strong> {{ $group->creator->name }}</p>
                        <hr>
                        <h6>Anggota ({{ $group->members->count() }})</h6>
                        <ul class="list-unstyled">
                            @foreach($group->members as $member)
                            <li class="mb-2 d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-user-circle text-primary"></i>
                                    {{ $member->user->name }}
                                    @if($member->role === 'admin')
                                        <span class="badge badge-warning">Admin</span>
                                    @endif
                                </span>
                                @if($isAdmin && $member->user_id !== Auth::id())
                                <form action="{{ route('chat.group.removeMember', $group->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $member->user_id }}">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Keluarkan anggota ini?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                            </li>
                            @endforeach
                        </ul>

                        {{-- Tambah Member --}}
                        @if($isAdmin)
                        <hr>
                        <h6>Tambah Anggota</h6>
                        @php
                            $memberIds = $group->members->pluck('user_id')->toArray();
                            $available = \App\Models\User::where('roles', 'siswa')
                                ->whereNotIn('id', $memberIds)->get();
                        @endphp
                        @if($available->isNotEmpty())
                        <form action="{{ route('chat.group.addMember', $group->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <select name="user_id" class="form-control form-control-sm">
                                    @foreach($available as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                            <small class="text-muted">Semua siswa sudah menjadi anggota</small>
                        @endif

                        <hr>
                        <form action="{{ route('chat.group.destroy', $group->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block btn-sm"
                                    onclick="return confirm('Hapus grup ini?')">
                                <i class="fas fa-trash"></i> Hapus Grup
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Scripts --}}
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const groupId   = {{ $group->id }};
    const userId    = {{ Auth::id() }};
    const userName  = "{{ Auth::user()->name }}";
    const sendUrl   = "{{ route('chat.group.send', $group->id) }}";
    const csrfToken = "{{ csrf_token() }}";

    // Scroll ke bawah
    const chatBox = document.getElementById('chat-messages');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Pusher setup
    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
    });

    const channel = pusher.subscribe('chat-group.' + groupId);
    channel.bind('App\\Events\\GroupMessageSent', function(data) {
        appendMessage(data, false);
    });

    // Kirim pesan
    @if(Auth::user()->roles !== 'guru')
    document.getElementById('send-btn').addEventListener('click', sendMessage);
    document.getElementById('message-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendMessage();
    });

    function sendMessage() {
        const input = document.getElementById('message-input');
        const msg   = input.value.trim();
        if (!msg) return;

        input.value = '';

        fetch(sendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.error) {
                appendMessage(data, true);
            }
        });
    }
    @endif

    function appendMessage(data, isSelf) {
        const div = document.createElement('div');
        div.className = 'd-flex mb-2 ' + (isSelf ? 'justify-content-end' : 'justify-content-start');

        if (isSelf) {
            div.innerHTML = `
                <div style="max-width:70%;">
                    <div class="bg-primary text-white rounded px-3 py-2">${data.message}</div>
                    <small class="text-muted d-block text-right">${data.created_at}</small>
                </div>`;
        } else {
            div.innerHTML = `
                <div style="max-width:70%;">
                    <small class="text-muted d-block"><strong>${data.user_name}</strong></small>
                    <div class="bg-white border rounded px-3 py-2">${data.message}</div>
                    <small class="text-muted d-block">${data.created_at}</small>
                </div>`;
        }

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
@endsection