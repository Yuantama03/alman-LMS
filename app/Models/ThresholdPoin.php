<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThresholdPoin extends Model
{
    use HasFactory;

    protected $table = 'threshold_poins';

    protected $fillable = [
        'kelas_id',
        'sangat_baik',
        'baik',
        'cukup',
        'kurang',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function getStatus(int $totalPoin): array
    {
        if ($totalPoin >= $this->sangat_baik) {
            return [
                'label' => 'Sangat Baik',
                'color' => 'success',
                'badge' => 'badge-success',
                'icon'  => '⭐',
            ];
        } elseif ($totalPoin >= $this->baik) {
            return [
                'label' => 'Baik',
                'color' => 'primary',
                'badge' => 'badge-primary',
                'icon'  => '👍',
            ];
        } elseif ($totalPoin >= $this->cukup) {
            return [
                'label' => 'Cukup',
                'color' => 'warning',
                'badge' => 'badge-warning',
                'icon'  => '📝',
            ];
        } elseif ($totalPoin >= $this->kurang) {
            return [
                'label' => 'Kurang',
                'color' => 'orange',
                'badge' => 'badge-orange',
                'icon'  => '⚠️',
            ];
        } else {
            return [
                'label' => 'Perlu Perhatian',
                'color' => 'danger',
                'badge' => 'badge-danger',
                'icon'  => '🚨',
            ];
        }
    }

    public static function getDefault(): self
    {
        $default = new self();
        $default->sangat_baik = 90;
        $default->baik        = 75;
        $default->cukup       = 60;
        $default->kurang      = 40;
        return $default;
    }
}