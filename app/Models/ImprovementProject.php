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
        'bod_score',
        'bod_scores_json',
        'bod_komentar',
        'bod_rekomendasi',
        'bod_dinilai_oleh',
        'bod_tanggal_penilaian',
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
