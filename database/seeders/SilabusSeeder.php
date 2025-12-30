<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SilabusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('silabus')->insert([
            [
                'mapel_id' => 1,
                'kelas_id' => 1,
                'semester_id' => 1,
                'deskripsi' => 'Silabus mata pelajaran untuk semester ganjil',
                'kompetensi_dasar' => 'Memahami konsep dasar dan prinsip-prinsip fundamental dalam mata pelajaran ini',
                'tujuan_pembelajaran' => 'Siswa mampu menguasai konsep dasar dan mengaplikasikannya dalam kehidupan sehari-hari',
                'materi_pokok' => 'Bab 1: Pengenalan Dasar, Bab 2: Konsep Fundamental, Bab 3: Aplikasi Praktis',
                'metode_pembelajaran' => 'Ceramah, Diskusi, Praktik, Presentasi',
                'alokasi_waktu' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mapel_id' => 2,
                'kelas_id' => 2,
                'semester_id' => 1,
                'deskripsi' => 'Silabus mata pelajaran untuk pengembangan kompetensi siswa',
                'kompetensi_dasar' => 'Menganalisis dan mengevaluasi informasi dari berbagai sumber',
                'tujuan_pembelajaran' => 'Siswa dapat berpikir kritis dan analitis dalam memecahkan masalah',
                'materi_pokok' => 'Bab 1: Teknik Analisis, Bab 2: Evaluasi Informasi, Bab 3: Pemecahan Masalah',
                'metode_pembelajaran' => 'Diskusi Kelompok, Studi Kasus, Project Based Learning',
                'alokasi_waktu' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
