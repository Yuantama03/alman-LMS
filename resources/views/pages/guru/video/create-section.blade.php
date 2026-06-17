@extends('layouts.main')
@section('title', 'Tambah Section Video')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Section Video</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.video.section.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Judul Section <span class="text-danger">*</span></label>
                                <input type="text" name="judul"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       value="{{ old('judul') }}"
                                       placeholder="Contoh: Persiapan dan Installasi"
                                       required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select name="mapel_id" class="form-control">
                                    <option value="">-- Pilih Mapel (opsional) --</option>
                                    @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"
                                          placeholder="Deskripsi singkat section ini...">{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Section
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
@endsection