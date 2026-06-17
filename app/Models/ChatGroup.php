<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $fillable = ['nama_grup', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(ChatGroupMember::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatGroupMessage::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_group_members')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}