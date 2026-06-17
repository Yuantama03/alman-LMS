<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPembelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_section_id',
        'judul',
        'youtube_url',
        'durasi',
        'urutan',
        'created_by'
    ];

    public function section()
    {
        return $this->belongsTo(VideoSection::class, 'video_section_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Convert YouTube URL ke embed URL
     * Support: youtu.be/xxx, youtube.com/watch?v=xxx
     */
    public function getEmbedUrlAttribute(): string
    {
        $url = $this->youtube_url;

        // youtu.be/VIDEO_ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // youtube.com/watch?v=VIDEO_ID
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }
}