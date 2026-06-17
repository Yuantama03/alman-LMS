@extends('layouts.main')
@section('title', 'Chat Kelompok')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Chat Kelompok</h4>
                        @if(Auth::user()->roles === 'siswa')
                        <a href="{{ route('chat.group.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Grup
                        </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        @if($groups->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada grup chat.</p>
                                @if(Auth::user()->roles === 'siswa')
                                <a href="{{ route('chat.group.create') }}" class="btn btn-primary">
                                    Buat Grup Pertama
                                </a>
                                @endif
                            </div>
                        @else
                        <div class="row">
                            @foreach($groups as $group)
                            <div class="col-md-4 mb-3">
                                <div class="card border h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-users text-primary"></i>
                                            {{ $group->nama_grup }}
                                        </h5>
                                        <p class="text-muted mb-1">
                                            <small>Dibuat oleh: <strong>{{ $group->creator->name }}</strong></small>
                                        </p>
                                        <p class="text-muted mb-3">
                                            <small><i class="fas fa-user"></i> {{ $group->members->count() }} anggota</small>
                                        </p>
                                        <a href="{{ route('chat.group.show', $group->id) }}"
                                           class="btn btn-primary btn-sm btn-block">
                                            <i class="fas fa-comment"></i> Buka Chat
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection