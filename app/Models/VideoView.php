<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_pembelajaran_id',
        'user_id',
        'jumlah_tonton',
    ];

    public function video()
    {
        return $this->belongsTo(VideoPembelajaran::class, 'video_pembelajaran_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}