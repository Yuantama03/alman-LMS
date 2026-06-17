@extends('layouts.main')
@section('title', 'Set Threshold - ' . $siswa->nama)

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Set Threshold Poin — {{ $siswa->nama }}</h4>
                        <small class="text-muted">Kelas {{ $siswa->kelas->nama_kelas ?? '-' }} | NIS: {{ $siswa->nis }}</small>
                    </div>
                    <div class="card-body">
                        @include('partials.alert')

                        @if($errors->has('urutan'))
                            <div class="alert alert-danger">{{ $errors->first('urutan') }}</div>
                        @endif

                        {{-- Preview Rule --}}
                        <div class="alert alert-light border mb-4">
                            <strong>Preview Rule:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Poin ≥ <span id="prev_sb">{{ $threshold->sangat_baik }}</span> → <span class="badge badge-success">Sangat Baik</span></li>
                                <li>Poin ≥ <span id="prev_b">{{ $threshold->baik }}</span> → <span class="badge badge-primary">Baik</span></li>
                                <li>Poin ≥ <span id="prev_c">{{ $threshold->cukup }}</span> → <span class="badge badge-warning">Cukup</span></li>
                                <li>Poin ≥ <span id="prev_k">{{ $threshold->kurang }}</span> → <span class="badge" style="background:#fd7e14;color:#fff;">Kurang</span></li>
                                <li>Poin &lt; <span id="prev_k2">{{ $threshold->kurang }}</span> → <span class="badge badge-danger">Perlu Perhatian</span></li>
                            </ul>
                        </div>

                        @if(Auth::user()->roles === 'admin')
                            @php $updateRoute = route('admin.threshold.siswa.update', $siswa->id) @endphp
                        @else
                            @php $updateRoute = route('guru.threshold.siswa.update', $siswa->id) @endphp
                        @endif

                        <form action="{{ $updateRoute }}" method="POST">
                            @csrf @method('PUT')

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <span class="badge badge-success">Sangat Baik</span> — Poin ≥
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" name="sangat_baik" id="sangat_baik"
                                           class="form-control @error('sangat_baik') is-invalid @enderror"
                                           value="{{ old('sangat_baik', $threshold->sangat_baik) }}"
                                           min="1" max="500" required>
                                    @error('sangat_baik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <span class="badge badge-primary">Baik</span> — Poin ≥
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" name="baik" id="baik"
                                           class="form-control @error('baik') is-invalid @enderror"
                                           value="{{ old('baik', $threshold->baik) }}"
                                           min="1" max="500" required>
                                    @error('baik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <span class="badge badge-warning">Cukup</span> — Poin ≥
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" name="cukup" id="cukup"
                                           class="form-control @error('cukup') is-invalid @enderror"
                                           value="{{ old('cukup', $threshold->cukup) }}"
                                           min="1" max="500" required>
                                    @error('cukup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <span class="badge" style="background:#fd7e14;color:#fff;">Kurang</span> — Poin ≥
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" name="kurang" id="kurang"
                                           class="form-control @error('kurang') is-invalid @enderror"
                                           value="{{ old('kurang', $threshold->kurang) }}"
                                           min="1" max="500" required>
                                    @error('kurang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <small class="text-muted">Di bawah nilai ini = <span class="badge badge-danger">Perlu Perhatian</span></small>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Threshold
                                    </button>
                                    @if(Auth::user()->roles === 'admin')
                                    <a href="{{ route('admin.threshold.siswa.index') }}" class="btn btn-secondary ml-2">Batal</a>
                                    @else
                                    <a href="{{ route('guru.threshold.siswa.index') }}" class="btn btn-secondary ml-2">Batal</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
['sangat_baik', 'baik', 'cukup', 'kurang'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', function() {
        var map = { sangat_baik: ['prev_sb'], baik: ['prev_b'], cukup: ['prev_c'], kurang: ['prev_k', 'prev_k2'] };
        map[id].forEach(function(t) {
            document.getElementById(t).textContent = this.value;
        }.bind(this));
    });
});
</script>
@endsection