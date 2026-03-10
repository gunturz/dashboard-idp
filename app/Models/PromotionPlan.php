<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionPlan extends Model
{
    protected $table = 'promotion_plan';
    protected $fillable = ['target_position_id'];

    public function targetPosition()
    {
        return $this->belongsTo(Position::class, 'target_position_id');
    }
}
