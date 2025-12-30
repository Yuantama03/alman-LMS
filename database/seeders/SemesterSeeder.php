<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semesters')->insert([
            [
                'nama_semester' => 'Ganjil',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_semester' => 'Genap',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2025-01-06',
                'tanggal_selesai' => '2025-06-20',
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'tanggal_mulai' => '2023-07-17',
                'tanggal_selesai' => '2023-12-22',
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_semester' => 'Genap',
                'tahun_ajaran' => '2023/2024',
                'tanggal_mulai' => '2024-01-08',
                'tanggal_selesai' => '2024-06-21',
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
