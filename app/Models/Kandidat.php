<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Kandidat extends Model
{
    use HasFactory;

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
    ];

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
