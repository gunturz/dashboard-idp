<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competence extends Model
{
    use SoftDeletes;
    protected $table = 'competencies';
    protected $fillable = ['name', 'category'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'competence_id')->orderBy('level');
    }

    public function targetCompetences()
    {
        return $this->hasMany(PositionTargetCompetence::class, 'competence_id');
    }
}
