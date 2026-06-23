<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['nis', 'nama', 'kelas_id', 'telp', 'alamat', 'foto'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function orangtua()
    {
        return $this->belongsToMany(Orangtua::class, 'orangtua_siswas', 'siswa_id', 'orangtua_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poinSiswa()
    {
        return $this->hasMany(PoinSiswa::class, 'siswa_id');
    }

    public function thresholdPoin()
    {
        return $this->hasOne(ThresholdPoinSiswa::class);
    }

    public function spSiswa()
    {
        return $this->hasMany(SpSiswa::class, 'siswa_id');
    }

    /**
     * Get total poin negatif siswa (dari pelanggaran)
     */
    public function getTotalPoinNegatif()
    {
        $total = $this->poinSiswa()
            ->where('jenis', 'Pelanggaran')
            ->sum('poin');
        
        return abs($total);
    }

    /**
     * Get SP aktif siswa
     */
    public function getSpAktif()
    {
        return $this->spSiswa()->aktif()->orderBy('tanggal_sp', 'desc')->get();
    }

    /**
     * Check dan create SP otomatis berdasarkan poin (Progressive)
     * SP 1: poin >= 50
     * SP 2: poin >= 75
     * SP 3: poin >= 100
     */
    public function checkAndCreateSp()
    {
        $totalPoinNegatif = $this->getTotalPoinNegatif();
        
        $activeSp = $this->spSiswa()->aktif()->first();
        $currentSpLevel = $activeSp ? (int)filter_var($activeSp->level_sp, FILTER_SANITIZE_NUMBER_INT) : 0;

        // REVOKE SP jika poin turun
        if ($totalPoinNegatif < 100 && $currentSpLevel == 3) {
            $sp3 = $this->spSiswa()->where('level_sp', 'SP 3')->aktif()->first();
            if ($sp3) {
                $sp3->update([
                    'status' => 'Revoked',
                    'tanggal_release' => now()->toDateString()
                ]);
            }
            $currentSpLevel = 2;
        }

        if ($totalPoinNegatif < 75 && $currentSpLevel == 2) {
            $sp2 = $this->spSiswa()->where('level_sp', 'SP 2')->aktif()->first();
            if ($sp2) {
                $sp2->update([
                    'status' => 'Revoked',
                    'tanggal_release' => now()->toDateString()
                ]);
            }
            $currentSpLevel = 1;
        }

        if ($totalPoinNegatif < 50 && $currentSpLevel >= 1) {
            $sp1 = $this->spSiswa()->where('level_sp', 'SP 1')->aktif()->first();
            if ($sp1) {
                $sp1->update([
                    'status' => 'Revoked',
                    'tanggal_release' => now()->toDateString()
                ]);
            }
            return 'Revoked SP 1';
        }

        // CREATE/UPGRADE SP jika poin naik
        if ($totalPoinNegatif >= 100 && $currentSpLevel == 2) {
            $sp2 = $this->spSiswa()->where('level_sp', 'SP 2')->aktif()->first();
            if ($sp2) {
                $sp2->update([
                    'status' => 'Revoked',
                    'tanggal_release' => now()->toDateString()
                ]);
            }
            $this->createOrUpdateSp('SP 3', $totalPoinNegatif, 'Upgrade dari SP 2 - Poin mencapai 100');
            return 'SP 3';
        }

        if ($totalPoinNegatif >= 75 && $currentSpLevel == 1) {
            $sp1 = $this->spSiswa()->where('level_sp', 'SP 1')->aktif()->first();
            if ($sp1) {
                $sp1->update([
                    'status' => 'Revoked',
                    'tanggal_release' => now()->toDateString()
                ]);
            }
            $this->createOrUpdateSp('SP 2', $totalPoinNegatif, 'Upgrade dari SP 1 - Poin mencapai 75');
            return 'SP 2';
        }

        if ($totalPoinNegatif >= 50 && $currentSpLevel == 0) {
            $this->createOrUpdateSp('SP 1', $totalPoinNegatif, 'Poin mencapai 50');
            return 'SP 1';
        }

        return null;
    }

    /**
     * Create or update SP untuk siswa
     */
    private function createOrUpdateSp($levelSp, $poinSaat, $alasan)
    {
        $existingSp = $this->spSiswa()
            ->where('level_sp', $levelSp)
            ->where('status', 'Aktif')
            ->first();

        if (!$existingSp) {
            \App\Models\SpSiswa::create([
                'siswa_id' => $this->id,
                'level_sp' => $levelSp,
                'poin_saat_sp' => $poinSaat,
                'tanggal_sp' => now()->toDateString(),
                'status' => 'Aktif',
                'alasan' => $alasan,
                'created_by' => auth()->id() ?? 1,
            ]);
        }
    }
}