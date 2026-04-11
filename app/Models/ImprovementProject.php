<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImprovementProject extends Model
{
    protected $table = 'improvement_project';

    protected $fillable = [
        'user_id_talent',
        'title',
        'document_path',
        'status',
        'verify_by',
        'verify_at',
        'feedback',
        'finance_feedback',
        'panelis_score',
        'panelis_scores_json',
        'panelis_komentar',
        'panelis_rekomendasi',
        'panelis_dinilai_oleh',
        'panelis_tanggal_penilaian',
    ];

    protected $casts = [
        'verify_at' => 'datetime',
    ];

    public function talent()
    {
        return $this->belongsTo(User::class , 'user_id_talent');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class , 'verify_by');
    }
}
