<?php

namespace App\Observers;

use App\Models\PoinSiswa;
use App\Models\Siswa;

class PoinSiswaObserver
{
    /**
     * Handle the PoinSiswa "created" event.
     */
    public function created(PoinSiswa $poinSiswa): void
    {
        // Trigger check SP ketika poin baru dibuat
        $siswa = $poinSiswa->siswa;
        if ($siswa) {
            $siswa->checkAndCreateSp();
        }
    }

    /**
     * Handle the PoinSiswa "updated" event.
     */
    public function updated(PoinSiswa $poinSiswa): void
    {
        // Trigger check SP ketika poin diupdate
        $siswa = $poinSiswa->siswa;
        if ($siswa) {
            $siswa->checkAndCreateSp();
        }
    }

    /**
     * Handle the PoinSiswa "deleted" event.
     */
    public function deleted(PoinSiswa $poinSiswa): void
    {
        // Trigger check SP ketika poin dihapus
        // Bisa juga logic untuk revoke SP jika poin turun kembali
        $siswa = $poinSiswa->siswa;
        if ($siswa) {
            $siswa->checkAndCreateSp();
        }
    }
}