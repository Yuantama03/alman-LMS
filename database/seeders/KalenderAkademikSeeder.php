<?php

namespace Database\Seeders;

use App\Models\KalenderAkademik;
use App\Models\Semester;
use Illuminate\Database\Seeder;

class KalenderAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get active semester
        $activeSemester = Semester::where('status_aktif', true)->first();

        $kalender = [
            [
                'judul' => 'Libur Tahun Baru',
                'deskripsi' => 'Libur Nasional Tahun Baru 2025',
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-01-01',
                'jenis_kegiatan' => 'Libur',
                'warna' => '#dc3545',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Penerimaan Siswa Baru',
                'deskripsi' => 'Periode pendaftaran siswa baru tahun ajaran 2025/2026',
                'tanggal_mulai' => '2025-06-01',
                'tanggal_selesai' => '2025-06-30',
                'jenis_kegiatan' => 'Pendaftaran',
                'warna' => '#17a2b8',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Ujian Tengah Semester Gasal',
                'deskripsi' => 'Ujian Tengah Semester untuk semester gasal tahun ajaran 2025/2026',
                'tanggal_mulai' => '2025-10-13',
                'tanggal_selesai' => '2025-10-20',
                'jenis_kegiatan' => 'Ujian',
                'warna' => '#ffc107',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Ujian Akhir Semester Gasal',
                'deskripsi' => 'Ujian Akhir Semester untuk semester gasal tahun ajaran 2025/2026',
                'tanggal_mulai' => '2025-12-08',
                'tanggal_selesai' => '2025-12-15',
                'jenis_kegiatan' => 'Ujian',
                'warna' => '#ffc107',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Libur Semester Gasal',
                'deskripsi' => 'Libur akhir semester gasal',
                'tanggal_mulai' => '2025-12-22',
                'tanggal_selesai' => '2026-01-05',
                'jenis_kegiatan' => 'Libur',
                'warna' => '#dc3545',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Awal Semester Genap',
                'deskripsi' => 'Mulai pembelajaran semester genap tahun ajaran 2025/2026',
                'tanggal_mulai' => '2026-01-06',
                'tanggal_selesai' => '2026-01-06',
                'jenis_kegiatan' => 'Pembelajaran',
                'warna' => '#6f42c1',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Ujian Tengah Semester Genap',
                'deskripsi' => 'Ujian Tengah Semester untuk semester genap tahun ajaran 2025/2026',
                'tanggal_mulai' => '2026-03-16',
                'tanggal_selesai' => '2026-03-23',
                'jenis_kegiatan' => 'Ujian',
                'warna' => '#ffc107',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Ujian Kenaikan Kelas',
                'deskripsi' => 'Ujian untuk menentukan kenaikan kelas siswa',
                'tanggal_mulai' => '2026-06-08',
                'tanggal_selesai' => '2026-06-15',
                'jenis_kegiatan' => 'Ujian',
                'warna' => '#ffc107',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Pengumuman Kenaikan Kelas',
                'deskripsi' => 'Pengumuman hasil ujian dan kenaikan kelas',
                'tanggal_mulai' => '2026-06-22',
                'tanggal_selesai' => '2026-06-22',
                'jenis_kegiatan' => 'Acara',
                'warna' => '#28a745',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Libur Kenaikan Kelas',
                'deskripsi' => 'Libur setelah pengumuman kenaikan kelas',
                'tanggal_mulai' => '2026-06-23',
                'tanggal_selesai' => '2026-07-12',
                'jenis_kegiatan' => 'Libur',
                'warna' => '#dc3545',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Hari Raya Idul Fitri',
                'deskripsi' => 'Libur Hari Raya Idul Fitri 1446 H (estimasi)',
                'tanggal_mulai' => '2025-03-30',
                'tanggal_selesai' => '2025-04-05',
                'jenis_kegiatan' => 'Libur',
                'warna' => '#dc3545',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Hari Raya Idul Adha',
                'deskripsi' => 'Libur Hari Raya Idul Adha 1446 H (estimasi)',
                'tanggal_mulai' => '2025-06-06',
                'tanggal_selesai' => '2025-06-07',
                'jenis_kegiatan' => 'Libur',
                'warna' => '#dc3545',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Hari Kemerdekaan RI',
                'deskripsi' => 'Peringatan Hari Kemerdekaan Republik Indonesia ke-80',
                'tanggal_mulai' => '2025-08-17',
                'tanggal_selesai' => '2025-08-17',
                'jenis_kegiatan' => 'Acara',
                'warna' => '#28a745',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Hari Guru Nasional',
                'deskripsi' => 'Peringatan Hari Guru Nasional',
                'tanggal_mulai' => '2025-11-25',
                'tanggal_selesai' => '2025-11-25',
                'jenis_kegiatan' => 'Acara',
                'warna' => '#28a745',
                'semester_id' => $activeSemester->id ?? null,
            ],
            [
                'judul' => 'Libur Natal',
                'deskripsi' => 'Libur Hari Natal',
                'tanggal_mulai' => '2025-12-25',
                'tanggal_selesai' => '2025-12-25',
                'jenis_kegiatan' => 'Libur',
                'warna' => '#dc3545',
                'semester_id' => $activeSemester->id ?? null,
            ],
        ];

        foreach ($kalender as $item) {
            KalenderAkademik::create($item);
        }
    }
}
