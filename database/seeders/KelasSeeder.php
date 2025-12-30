<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kelas 7
        DB::table('kelas')->insert([
            'nama_kelas' => '7A',
            'guru_id' => 1,
        ]);
        DB::table('kelas')->insert([
            'nama_kelas' => '7B',
            'guru_id' => 2,
        ]);

        // Kelas 8
        DB::table('kelas')->insert([
            'nama_kelas' => '8A',
            'guru_id' => 1,
        ]);
        DB::table('kelas')->insert([
            'nama_kelas' => '8B',
            'guru_id' => 2,
        ]);

        // Kelas 9
        DB::table('kelas')->insert([
            'nama_kelas' => '9A',
            'guru_id' => 1,
        ]);
        DB::table('kelas')->insert([
            'nama_kelas' => '9B',
            'guru_id' => 2,
        ]);
    }
}
