<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditActivity extends Model
{
    protected $table = 'audit_activity';

    // Field yang boleh diisi massal (mass assignment)
    protected $fillable = [
        'user_id',
        'event',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    // Otomatis encode/decode JSON untuk kolom 'properties'
    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Relasi ke tabel users (siapa yang melakukan aksi)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
