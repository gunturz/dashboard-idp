<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id_talent',
        'source_position_id',
        'target_position_id',
        'atasan_id',
        'mentor_ids',
        'status',
        'start_date',
        'target_date',
        'completed_at',
        'is_active',
    ];

    protected $casts = [
        'mentor_ids' => 'array',
        'start_date' => 'date',
        'target_date' => 'date',
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'status' => 'In Progress',
        'is_active' => true,
    ];

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
    }

    public function targetPosition()
    {
        return $this->belongsTo(Position::class, 'target_position_id');
    }

    public function sourcePosition()
    {
        return $this->belongsTo(Position::class, 'source_position_id');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function promotionPlan()
    {
        return $this->hasOne(PromotionPlan::class, 'development_session_id');
    }

    public function assessmentSessions()
    {
        return $this->hasMany(AssessmentSession::class, 'development_session_id');
    }

    public function idpActivities()
    {
        return $this->hasMany(IdpActivity::class, 'development_session_id');
    }

    public function improvementProjects()
    {
        return $this->hasMany(ImprovementProject::class, 'development_session_id');
    }

    public function panelisAssessments()
    {
        return $this->hasMany(PanelisAssessment::class, 'development_session_id');
    }

    public function getMentorModelsAttribute()
    {
        if (empty($this->mentor_ids)) {
            return collect();
        }

        return User::whereIn('id', $this->mentor_ids)->get();
    }
}
