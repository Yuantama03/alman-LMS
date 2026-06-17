@extends('layouts.main')
@section('title', 'Buat Grup Chat')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Buat Grup Chat Baru</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        <form action="{{ route('chat.group.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Nama Grup</label>
                                <input type="text" name="nama_grup"
                                       class="form-control @error('nama_grup') is-invalid @enderror"
                                       value="{{ old('nama_grup') }}"
                                       placeholder="Contoh: Kelompok Matematika A"
                                       required>
                                @error('nama_grup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Invite Anggota</label>
                                <small class="text-muted d-block mb-2">Pilih siswa yang ingin diajak bergabung</small>
                                @error('members')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="row">
                                    @foreach($siswaList as $siswa)
                                    <div class="col-md-4 mb-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="siswa_{{ $siswa->id }}"
                                                   name="members[]"
                                                   value="{{ $siswa->id }}"
                                                   {{ in_array($siswa->id, old('members', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="siswa_{{ $siswa->id }}">
                                                {{ $siswa->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Buat Grup
                                </button>
                                <a href="{{ route('chat.group.index') }}" class="btn btn-secondary ml-2">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection