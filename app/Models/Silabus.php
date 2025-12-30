<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silabus extends Model
{
    use HasFactory;

    protected $table = 'silabus';

    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'semester_id',
        'deskripsi',
        'kompetensi_dasar',
        'tujuan_pembelajaran',
        'materi_pokok',
        'metode_pembelajaran',
        'alokasi_waktu'
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
