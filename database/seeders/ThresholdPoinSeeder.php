<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\ThresholdPoin;
use Illuminate\Database\Seeder;

class ThresholdPoinSeeder extends Seeder
{
    public function run()
    {
        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            ThresholdPoin::updateOrCreate(
                ['kelas_id' => $kelas->id],
                [
                    'sangat_baik' => 90,
                    'baik'        => 75,
                    'cukup'       => 60,
                    'kurang'      => 40,
                ]
            );
        }
    }
}