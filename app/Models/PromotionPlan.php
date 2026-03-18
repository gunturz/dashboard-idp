<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionPlan extends Model
{
    protected $table = 'promotion_plan';
    protected $fillable = ['user_id_talent', 'target_position_id', 'mentor_ids', 'status_promotion', 'start_date', 'target_date'];

    protected $casts = [
        'mentor_ids' => 'array',
    ];

    protected $attributes = [
        'status_promotion' => 'Draft',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->start_date)) {
                $model->start_date = now();
            }
            if (empty($model->target_date)) {
                $model->target_date = now()->addYear();
            }
        });
    }

    public function targetPosition()
    {
        return $this->belongsTo(Position::class , 'target_position_id');
    }

    /**
     * All mentors stored in the JSON column
     */
    public function mentors()
    {
        return $this->belongsToMany(User::class , null, null, null)
            ->whereIn('users.id', $this->mentor_ids ?? []);
    // Use a simple query instead; see accessor below
    }

    /**
     * Fetch all mentor User models based on mentor_ids JSON array
     */
    public function getMentorModelsAttribute()
    {
        if (empty($this->mentor_ids))
            return collect();
        return \App\Models\User::whereIn('id', $this->mentor_ids)->get();
    }
}
