<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mata Pelajaran SMP (jurusan_id = 1 untuk 'Umum')
        $mapelSMP = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA (Ilmu Pengetahuan Alam)',
            'IPS (Ilmu Pengetahuan Sosial)',
            'Pendidikan Agama',
            'PKn (Pendidikan Kewarganegaraan)',
            'Seni Budaya',
            'PJOK (Pendidikan Jasmani, Olahraga dan Kesehatan)',
            'Prakarya',
            'TIK (Teknologi Informasi dan Komunikasi)',
        ];

        foreach ($mapelSMP as $mapel) {
            DB::table('mapels')->insert([
                'nama_mapel' => $mapel,
                'jurusan_id' => 1, // Umum
            ]);
        }
    }
}
