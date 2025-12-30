<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Hadir', 'Sakit', 'Izin', 'Alpha'];
        $today = Carbon::today();
        
        // Generate presensi for the last 10 days
        for ($i = 0; $i < 10; $i++) {
            $date = $today->copy()->subDays($i);
            
            // Presensi untuk siswa 1 (kelas 1)
            DB::table('presensis')->insert([
                'siswa_id' => 1,
                'kelas_id' => 1,
                'tanggal' => $date,
                'status' => $statuses[array_rand($statuses)],
                'keterangan' => $i % 3 == 0 ? 'Keterangan sample' : null,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Presensi untuk siswa 2 (kelas 2)
            DB::table('presensis')->insert([
                'siswa_id' => 2,
                'kelas_id' => 2,
                'tanggal' => $date,
                'status' => $statuses[array_rand($statuses)],
                'keterangan' => null,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Generate additional presensi for current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;
        
        for ($day = 1; $day <= min($daysInMonth, 20); $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1);
            
            // Skip if already created above
            if ($date->isAfter($today->copy()->subDays(10))) {
                continue;
            }

            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            // Siswa 1
            if (!DB::table('presensis')->where('siswa_id', 1)->where('tanggal', $date)->exists()) {
                DB::table('presensis')->insert([
                    'siswa_id' => 1,
                    'kelas_id' => 1,
                    'tanggal' => $date,
                    'status' => $day % 10 == 0 ? 'Sakit' : ($day % 15 == 0 ? 'Izin' : 'Hadir'),
                    'keterangan' => null,
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Siswa 2
            if (!DB::table('presensis')->where('siswa_id', 2)->where('tanggal', $date)->exists()) {
                DB::table('presensis')->insert([
                    'siswa_id' => 2,
                    'kelas_id' => 2,
                    'tanggal' => $date,
                    'status' => $day % 12 == 0 ? 'Alpha' : 'Hadir',
                    'keterangan' => null,
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
