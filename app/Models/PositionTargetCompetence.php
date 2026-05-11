<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionTargetCompetence extends Model
{
    use SoftDeletes;
    protected $table = 'position_target_competence';
    protected $fillable = ['position_id', 'competence_id', 'target_level'];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }
}
