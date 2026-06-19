<?php

namespace App\Helpers;

class EarlyWarningHelper
{
    /**
     * Get early warning status berdasarkan poin
     */
    public static function getStatus($totalPoin)
    {
        if ($totalPoin <= 24) {
            return [
                'label' => 'HIJAU',
                'color' => 'success',
                'icon' => '🟢',
                'description' => 'BAIK (0-24 poin)',
                'bootstrap_class' => 'success'
            ];
        } elseif ($totalPoin <= 49) {
            return [
                'label' => 'KUNING',
                'color' => 'warning',
                'icon' => '🟡',
                'description' => 'Waspada (25-49 poin)',
                'bootstrap_class' => 'warning'
            ];
        } elseif ($totalPoin <= 74) {
            return [
                'label' => 'ORANGE',
                'color' => 'danger',
                'icon' => '🟠',
                'description' => 'Pembinaan - SP 1 Aktif (50-74 poin)',
                'bootstrap_class' => 'danger'
            ];
        } elseif ($totalPoin <= 99) {
            return [
                'label' => 'MERAH',
                'color' => 'danger',
                'icon' => '🔴',
                'description' => 'Pembinaan Intensif - SP 2 Aktif (75-99 poin)',
                'bootstrap_class' => 'danger'
            ];
        } else {
            return [
                'label' => 'HITAM',
                'color' => 'dark',
                'icon' => '⚫',
                'description' => 'Pengembalian Siswa - SP 3 (100 poin)',
                'bootstrap_class' => 'dark'
            ];
        }
    }

    /**
     * Get badge CSS class untuk progress bar
     */
    public static function getProgressBarClass($totalPoin)
    {
        if ($totalPoin <= 24) {
            return 'bg-success';
        } elseif ($totalPoin <= 49) {
            return 'bg-warning';
        } elseif ($totalPoin <= 74) {
            return 'bg-danger';
        } elseif ($totalPoin <= 99) {
            return 'bg-danger';
        } else {
            return 'bg-dark';
        }
    }
}