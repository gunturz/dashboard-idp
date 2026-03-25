<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'company_id',
        'department_id',
        'position_id',
        'role_id',
        'mentor_id',
        'atasan_id',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class , 'company_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class , 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class , 'position_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class , 'role_id');
    }

    public function promotion_plan()
    {
        return $this->hasOne(PromotionPlan::class , 'user_id_talent');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class , 'mentor_id');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class , 'atasan_id');
    }

    public function assessmentSession()
    {
        return $this->hasOne(AssessmentSession::class , 'user_id_talent');
    }

    public function idpActivities()
    {
        return $this->hasMany(IdpActivity::class , 'user_id_talent');
    }

    public function improvementProjects()
    {
        return $this->hasMany(ImprovementProject::class , 'user_id_talent');
    }

    public function getMenteesAttribute()
    {
        $id = $this->id;
        return User::with(['position', 'promotion_plan.targetPosition'])
            ->where(function ($q) use ($id) {
            // Talent yang punya promotion_plan dengan mentor_ids berisi ID ini
            $q->whereHas('promotion_plan', function ($query) use ($id) {
                    $query->whereNotNull('mentor_ids')
                        ->where(function ($inner) use ($id) {
                    $inner->whereJsonContains('mentor_ids', (string)$id)
                        ->orWhereJsonContains('mentor_ids', $id);
                }
                );
            }
            )
                // ATAU talent yang belum punya promotion_plan dengan mentor_ids, tapi punya mentor_id lama ini
                ->orWhere(function ($q2) use ($id) {
                $q2->where('mentor_id', $id)
                    ->whereDoesntHave('promotion_plan', function ($query) {
                    $query->whereNotNull('mentor_ids');
                }
                );
            }
            );
        })->get();
    }

    public function subordinates()
    {
        return $this->hasMany(User::class , 'atasan_id');
    }
}
