<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionPlan extends Model
{
    use SoftDeletes;
    protected $table = 'promotion_plan';
    protected $fillable = ['development_session_id', 'user_id_talent', 'target_position_id', 'mentor_ids', 'status_promotion', 'start_date', 'target_date', 'is_locked', 'is_active'];

    protected $casts = [
        'mentor_ids'  => 'array',
        'start_date'  => 'date',
        'target_date' => 'date',
    ];

    protected $attributes = [
        'status_promotion' => 'Draft',
        'is_active' => true,
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
        return $this->belongsTo(Position::class, 'target_position_id');
    }

    public function developmentSession()
    {
        return $this->belongsTo(DevelopmentSession::class, 'development_session_id');
    }

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
    }

    /**
     * All mentors stored in the JSON column
     */
    public function mentors()
    {
        return $this->belongsToMany(User::class, null, null, null)
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
