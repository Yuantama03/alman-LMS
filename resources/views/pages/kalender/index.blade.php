@extends('layouts.main')
@section('title', 'Kalender Akademik')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
    .fc-calendar {
        background: white;
        padding: 20px;
        border-radius: 8px;
    }
    .fc-event {
        cursor: pointer;
        border: none;
        padding: 4px 8px;
        font-size: 13px;
    }
    .fc-event:hover {
        opacity: 0.8;
        transform: translateY(-1px);
        transition: all 0.2s;
    }
    .fc-daygrid-event {
        border-radius: 4px;
    }
    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 600 !important;
        color: #34395e;
    }
    .fc-button {
        background-color: #6777ef !important;
        border-color: #6777ef !important;
        text-transform: capitalize !important;
    }
    .fc-button:hover {
        background-color: #394eea !important;
        border-color: #394eea !important;
    }
    .fc-button-active {
        background-color: #394eea !important;
    }
    .fc-col-header-cell {
        background-color: #f9f9f9;
        font-weight: 600;
        color: #34395e;
    }
    .badge-lg {
        font-size: 14px;
        padding: 8px 12px;
    }
</style>
@endpush

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jadwal Kegiatan Akademik</h4>
                        </div>
                        <div class="card-body">
                                <!-- Legend -->
                                <div class="alert alert-light mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Keterangan Jenis Kegiatan:</strong>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <span class="badge badge-danger mr-2 mb-2" style="font-size: 13px; padding: 6px 12px;">
                                            <i class="fas fa-umbrella-beach"></i> Libur
                                        </span>
                                        <span class="badge badge-warning mr-2 mb-2" style="font-size: 13px; padding: 6px 12px;">
                                            <i class="fas fa-file-alt"></i> Ujian
                                        </span>
                                        <span class="badge badge-success mr-2 mb-2" style="font-size: 13px; padding: 6px 12px;">
                                            <i class="fas fa-calendar-check"></i> Acara
                                        </span>
                                        <span class="badge badge-info mr-2 mb-2" style="font-size: 13px; padding: 6px 12px;">
                                            <i class="fas fa-user-plus"></i> Pendaftaran
                                        </span>
                                        <span class="badge badge-primary mr-2 mb-2" style="font-size: 13px; padding: 6px 12px;">
                                            <i class="fas fa-book-reader"></i> Pembelajaran
                                        </span>
                                        <span class="badge badge-secondary mr-2 mb-2" style="font-size: 13px; padding: 6px 12px;">
                                            <i class="fas fa-ellipsis-h"></i> Lainnya
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="calendar" class="fc-calendar"></div>
                        </div>
                    </div>
                </div>

                <!-- List View -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($kalender as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge badge-lg" style="background-color: {{ $item->warna }}; width: 10px; height: 10px; padding: 0; border-radius: 50%; margin-right: 8px;"></span>
                                                            <strong>{{ $item->judul }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $item->tanggal_mulai->format('d M Y') }}
                                                        @if($item->tanggal_selesai)
                                                            - {{ $item->tanggal_selesai->format('d M Y') }}
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
                                                    <td>{{ Str::limit($item->deskripsi, 50) ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada kegiatan akademik</td>
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
        </div>
    </section>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-tag mr-2 text-primary"></i>
                            <strong>Jenis Kegiatan:</strong>
                        </div>
                        <span id="modalJenis" class="badge badge-info ml-4"></span>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="far fa-calendar-alt mr-2 text-primary"></i>
                            <strong>Waktu Pelaksanaan:</strong>
                        </div>
                        <p class="ml-4 mb-0" id="modalTanggal"></p>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-align-left mr-2 text-primary"></i>
                            <strong>Deskripsi:</strong>
                        </div>
                        <p class="ml-4 mb-0" id="modalDeskripsi"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    var events = @json($events);
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,listMonth'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            list: 'Daftar'
        },
        events: events,
        eventClick: function(info) {
            var event = info.event;
            
            document.getElementById('modalTitle').textContent = event.title;
            
            var jenisBadge = document.getElementById('modalJenis');
            jenisBadge.textContent = event.extendedProps.jenis;
            jenisBadge.className = 'badge ';
            
            // Set badge color based on type
            var badgeClass = 'badge-secondary';
            switch(event.extendedProps.jenis) {
                case 'Libur': badgeClass = 'badge-danger'; break;
                case 'Ujian': badgeClass = 'badge-warning'; break;
                case 'Acara': badgeClass = 'badge-success'; break;
                case 'Pendaftaran': badgeClass = 'badge-info'; break;
                case 'Pembelajaran': badgeClass = 'badge-primary'; break;
            }
            jenisBadge.className = 'badge ' + badgeClass + ' badge-lg';
            
            var startDate = new Date(event.start);
            var tanggalText = startDate.toLocaleDateString('id-ID', { 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric' 
            });
            
            if (event.end) {
                var endDate = new Date(event.end);
                endDate.setDate(endDate.getDate() - 1); // Adjust for exclusive end date
                tanggalText += ' - ' + endDate.toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                });
            }
            
            document.getElementById('modalTanggal').textContent = tanggalText;
            document.getElementById('modalDeskripsi').textContent = event.extendedProps.description || '-';
            
            $('#detailModal').modal('show');
        }
    });
    
    calendar.render();
});
</script>
@endpush
