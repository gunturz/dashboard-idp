<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'perusahaan',
        'departemen',
        'jabatan',
        'jabatan_target',
        'mentor_id',
        'atasan_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Gunakan username sebagai identifier login (bukan email).
     */
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    /**
     * Relasi ke mentor (sesama user).
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Relasi ke atasan (sesama user).
     */
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }
}
