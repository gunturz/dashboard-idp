<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImprovementProject extends Model
{
    use SoftDeletes;
    protected $table = 'improvement_project';

    protected $fillable = [
        'user_id_talent',
        'development_session_id',
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
        'is_active',
    ];

    protected $casts = [
        'verify_at' => 'datetime',
    ];

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
    }

    public function developmentSession()
    {
        return $this->belongsTo(DevelopmentSession::class, 'development_session_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verify_by');
    }
}
