<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanelisAssessment extends Model
{
    protected $table = 'panelis_assessments';

    protected $fillable = [
        'user_id_talent',
        'panelis_id',
        'panelis_score',
        'panelis_scores_json',
        'panelis_komentar',
        'panelis_rekomendasi',
        'panelis_tanggal_penilaian',
    ];

    protected $casts = [
        'panelis_scores_json' => 'array',
        'panelis_tanggal_penilaian' => 'date',
    ];

    public function talent()
    {
        return $this->belongsTo(User::class , 'user_id_talent');
    }

    public function panelis()
    {
        return $this->belongsTo(User::class , 'panelis_id');
    }
}
