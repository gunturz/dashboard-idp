<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    protected $fillable = ['competence_id', 'level', 'question_text'];

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }
}
