<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'nis',
        'nip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function guru($id = null) {
        if ($id) {
            return Guru::where('nip', $id)->first();
        }
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function siswa($id = null) {
        if ($id) {
            return Siswa::where('nis', $id)->first();
        }
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function orangtua()
    {
        return $this->hasOne(Orangtua::class, 'user_id');
    }
}