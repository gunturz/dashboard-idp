<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $table = 'question';

    protected $fillable = ['competence_id', 'level', 'question_text'];

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }
}
