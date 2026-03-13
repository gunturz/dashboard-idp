<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentSession extends Model
{
    protected $table = 'assessment_session';
    protected $fillable = ['user_id_talent', 'user_id_atasan', 'period'];

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
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
