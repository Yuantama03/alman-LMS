@extends('layouts.main')
@section('title', 'Kalender Akademik')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Daftar Kegiatan Akademik</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                                <i class="fas fa-plus"></i> Tambah Kegiatan
                            </button>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Kegiatan</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Jenis</th>
                                                <th>Semester</th>
                                                <th>Warna</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($kalender as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge" style="background-color: {{ $item->warna }}; width: 10px; height: 10px; padding: 0; border-radius: 50%; margin-right: 8px;"></span>
                                                            <strong>{{ $item->judul }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <i class="far fa-calendar mr-1 text-muted"></i>
                                                        {{ $item->tanggal_mulai->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        @if($item->tanggal_selesai)
                                                            <i class="far fa-calendar-check mr-1 text-muted"></i>
                                                            {{ $item->tanggal_selesai->format('d M Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $badgeClass = match($item->jenis_kegiatan) {
                                                                'Libur' => 'badge-danger',
                                                                'Ujian' => 'badge-warning',
                                                                'Acara' => 'badge-success',
                                                                'Pendaftaran' => 'badge-info',
                                                                'Pembelajaran' => 'badge-primary',
                                                                default => 'badge-secondary'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">{{ $item->jenis_kegiatan }}</span>
                                                    </td>
                                                    <td>
                                                        @if($item->semester)
                                                            <span class="badge badge-light">{{ $item->semester->nama_semester }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge" style="background-color: {{ $item->warna }}; width: 30px; height: 20px; padding: 0; border-radius: 4px; margin-right: 6px; border: 1px solid #ddd;"></span>
                                                            <code style="font-size: 11px;">{{ $item->warna }}</code>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.kalender.edit', $item->id) }}" 
                                                           class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.kalender.destroy', $item->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data kegiatan akademik</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kegiatan Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.kalender.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                           name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                           name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kegiatan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('jenis_kegiatan') is-invalid @enderror" 
                                            name="jenis_kegiatan" id="jenisKegiatan" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Libur" {{ old('jenis_kegiatan') == 'Libur' ? 'selected' : '' }}>Libur</option>
                                        <option value="Ujian" {{ old('jenis_kegiatan') == 'Ujian' ? 'selected' : '' }}>Ujian</option>
                                        <option value="Acara" {{ old('jenis_kegiatan') == 'Acara' ? 'selected' : '' }}>Acara</option>
                                        <option value="Pendaftaran" {{ old('jenis_kegiatan') == 'Pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                                        <option value="Pembelajaran" {{ old('jenis_kegiatan') == 'Pembelajaran' ? 'selected' : '' }}>Pembelajaran</option>
                                        <option value="Lainnya" {{ old('jenis_kegiatan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('jenis_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Warna <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center mb-2">
                                        <input type="color" class="form-control @error('warna') is-invalid @enderror" 
                                               id="warnaInput" name="warna" value="{{ old('warna', '#3788d8') }}" required style="width: 80px; height: 40px; padding: 2px;">
                                        <span class="ml-2 text-muted small">atau pilih preset:</span>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #dc3545; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#dc3545')" title="Merah (Libur)"></button>
                                        <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #ffc107; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#ffc107')" title="Kuning (Ujian)"></button>
                                        <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #28a745; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#28a745')" title="Hijau (Acara)"></button>
                                        <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #17a2b8; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#17a2b8')" title="Biru Muda (Pendaftaran)"></button>
                                        <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #6777ef; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#6777ef')" title="Biru (Pembelajaran)"></button>
                                        <button type="button" class="btn btn-sm mr-1 mb-1" style="background-color: #6c757d; width: 30px; height: 30px; padding: 0; border-radius: 4px;" onclick="setColor('#6c757d')" title="Abu-abu (Lainnya)"></button>
                                    </div>
                                    @error('warna')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Semester</label>
                            <select class="form-control @error('semester_id') is-invalid @enderror" name="semester_id">
                                <option value="">-- Pilih Semester (Opsional) --</option>
                                @foreach(\App\Models\Semester::orderBy('tahun_ajaran', 'desc')->get() as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->nama_semester }} - {{ $semester->tahun_ajaran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function setColor(color) {
    document.getElementById('warnaInput').value = color;
}

// Auto-set color based on event type selection
document.getElementById('jenisKegiatan').addEventListener('change', function() {
    var colorMap = {
        'Libur': '#dc3545',
        'Ujian': '#ffc107',
        'Acara': '#28a745',
        'Pendaftaran': '#17a2b8',
        'Pembelajaran': '#6777ef',
        'Lainnya': '#6c757d'
    };
    
    var selectedType = this.value;
    if (colorMap[selectedType]) {
        document.getElementById('warnaInput').value = colorMap[selectedType];
    }
});
</script>
@endpush
