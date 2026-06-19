<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpSiswa extends Model
{
    use HasFactory;

    protected $table = 'sp_siswas';

    protected $fillable = [
        'siswa_id',
        'level_sp',
        'poin_saat_sp',
        'tanggal_sp',
        'status',
        'alasan',
        'tanggal_release',
        'created_by'
    ];

    protected $casts = [
        'tanggal_sp' => 'date',
        'tanggal_release' => 'date',
    ];

    // Relationship to Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relationship to User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Ambil SP aktif siswa
     */
    // Di app/Models/SpSiswa.php
public function scopeAktif($query)
{
    return $query->where('status', 'Aktif');
}
}