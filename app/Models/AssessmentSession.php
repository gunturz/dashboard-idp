<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentSession extends Model
{
    use SoftDeletes;
    protected $table = 'assessment_session';
    protected $fillable = ['development_session_id', 'user_id_talent', 'user_id_atasan', 'period', 'is_active'];

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
    }

    public function developmentSession()
    {
        return $this->belongsTo(DevelopmentSession::class, 'development_session_id');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'user_id_atasan');
    }

    public function details()
    {
        return $this->hasMany(DetailAssessment::class, 'assessment_id');
    }
}
