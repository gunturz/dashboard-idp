<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAssessment extends Model
{
    protected $table = 'detail_assessment';
    protected $fillable = ['assessment_id', 'competence_id', 'score_atasan', 'score_talent', 'gap_score', 'notes'];

    public function assessment()
    {
        return $this->belongsTo(AssessmentSession::class, 'assessment_id');
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }
}
