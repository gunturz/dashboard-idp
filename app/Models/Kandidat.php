<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Kandidat extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'kandidats';

    protected $fillable = [
        'nama',
        'role',
        'perusahaan',
        'departemen',
        'role_target',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolom yang digunakan sebagai identifier login.
     */
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    /**
     * Kolom password.
     */
    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    /**
     * Hash password otomatis saat diisi.
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }
}
