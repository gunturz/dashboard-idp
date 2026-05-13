<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PanelisAssessment extends Model
{
    use SoftDeletes;
    protected $table = 'panelis_assessments';

    protected $fillable = [
        'user_id_talent',
        'development_session_id',
        'panelis_id',
        'panelis_score',
        'panelis_scores_json',
        'panelis_komentar',
        'panelis_rekomendasi',
        'panelis_tanggal_penilaian',
        'is_active',
    ];

    protected $casts = [
        'panelis_scores_json' => 'array',
        'panelis_tanggal_penilaian' => 'date',
    ];

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
    }

    public function developmentSession()
    {
        return $this->belongsTo(DevelopmentSession::class, 'development_session_id');
    }

    public function panelis()
    {
        return $this->belongsTo(User::class, 'panelis_id');
    }
}
