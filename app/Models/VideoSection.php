<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'mapel_id', 'created_by', 'urutan'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function videos()
    {
        return $this->hasMany(VideoPembelajaran::class)->orderBy('urutan');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}