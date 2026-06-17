<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_pembelajaran_id',
        'user_id',
        'parent_id',
        'isi',
    ];

    public function video()
    {
        return $this->belongsTo(VideoPembelajaran::class, 'video_pembelajaran_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(VideoComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(VideoComment::class, 'parent_id')
            ->with('user')
            ->orderBy('created_at');
    }
}