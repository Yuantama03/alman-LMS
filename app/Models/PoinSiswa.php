<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinSiswa extends Model
{
    use HasFactory;

    protected $table = 'poin_siswas';

    protected $fillable = [
        'siswa_id',
        'jenis',
        'kategori',
        'deskripsi',
        'poin',
        'tanggal',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
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
}
