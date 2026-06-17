<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThresholdPoinSiswa extends Model
{
    use HasFactory;

    protected $table = 'threshold_poin_siswas';

    protected $fillable = [
        'siswa_id',
        'sangat_baik',
        'baik',
        'cukup',
        'kurang',
        'set_by',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function setter()
    {
        return $this->belongsTo(User::class, 'set_by');
    }

    /**
     * Rule-based: tentukan status berdasarkan total poin
     */
   public function getStatus(int $totalPoin): array
{
    if ($totalPoin >= $this->sangat_baik) {
        return ['label' => 'Sangat Baik', 'color' => 'success', 'icon' => '⭐'];
    } elseif ($totalPoin >= $this->baik) {
        return ['label' => 'Baik', 'color' => 'primary', 'icon' => '👍'];
    } elseif ($totalPoin >= $this->cukup) {
        return ['label' => 'Cukup', 'color' => 'warning', 'icon' => '📝'];
    } else {
        return ['label' => 'Kurang', 'color' => 'danger', 'icon' => '⚠️'];
    }
}

public static function getDefault(): self
{
    $default = new self();
    $default->sangat_baik = 100;
    $default->baik        = 75;
    $default->cukup       = 50;
    $default->kurang      = 0;
    return $default;
}
}