<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $table = 'competencies';
    protected $fillable = ['name'];

    public function targetCompetences()
    {
        return $this->hasMany(PositionTargetCompetence::class, 'competence_id');
    }
}
