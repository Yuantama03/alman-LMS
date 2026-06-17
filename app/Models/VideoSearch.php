<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mapel_id',
        'keyword',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}