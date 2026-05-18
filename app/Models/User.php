<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'foto'
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

    protected function applyActiveFilter(Relation $relation, string $table): Relation
    {
        if (Schema::hasColumn($table, 'is_active')) {
            $relation->where($table . '.is_active', true);
        }

        return $relation;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'id_user', 'id_role');
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return $this->roles->whereIn('role_name', $roles)->isNotEmpty();
    }

    public function promotion_plan()
    {
        return $this->applyActiveFilter(
            $this->hasOne(PromotionPlan::class, 'user_id_talent')->latestOfMany(),
            'promotion_plan'
        );
    }

    public function all_promotion_plans()
    {
        return $this->hasMany(PromotionPlan::class, 'user_id_talent')->orderBy('created_at', 'desc');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function developmentSessions()
    {
        return $this->hasMany(DevelopmentSession::class, 'user_id_talent')->orderBy('created_at', 'desc');
    }

    public function activeDevelopmentSession()
    {
        return $this->hasOne(DevelopmentSession::class, 'user_id_talent')
            ->where('is_active', true)
            ->latestOfMany();
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function assessmentSession()
    {
        return $this->applyActiveFilter(
            $this->hasOne(AssessmentSession::class, 'user_id_talent')->latestOfMany(),
            'assessment_session'
        );
    }

    public function all_assessmentSessions()
    {
        return $this->hasMany(AssessmentSession::class, 'user_id_talent')->orderBy('created_at', 'desc');
    }

    public function idpActivities()
    {
        return $this->applyActiveFilter(
            $this->hasMany(IdpActivity::class, 'user_id_talent'),
            'idp_activity'
        );
    }

    public function all_idpActivities()
    {
        return $this->hasMany(IdpActivity::class, 'user_id_talent')->orderBy('created_at', 'desc');
    }

    public function improvementProjects()
    {
        return $this->applyActiveFilter(
            $this->hasMany(ImprovementProject::class, 'user_id_talent'),
            'improvement_project'
        );
    }

    public function all_improvementProjects()
    {
        return $this->hasMany(ImprovementProject::class, 'user_id_talent')->orderBy('created_at', 'desc');
    }

    public function panelisAssessments()
    {
        return $this->applyActiveFilter(
            $this->hasMany(PanelisAssessment::class, 'user_id_talent'),
            'panelis_assessments'
        );
    }

    public function all_panelisAssessments()
    {
        return $this->hasMany(PanelisAssessment::class, 'user_id_talent')->orderBy('created_at', 'desc');
    }

    public function getMenteesAttribute()
    {
        $id = $this->id;

        return User::with(['position', 'department', 'promotion_plan.targetPosition'])
            ->where(function ($q) use ($id) {
                $q->whereHas('promotion_plan', function ($query) use ($id) {
                    $query->whereNotNull('mentor_ids')
                        ->where(function ($inner) use ($id) {
                            $inner->whereJsonContains('mentor_ids', (string) $id)
                                ->orWhereJsonContains('mentor_ids', $id);
                        });
                })
                    ->orWhere(function ($legacyQuery) use ($id) {
                        $legacyQuery->where('mentor_id', $id)
                            ->whereHas('promotion_plan', function ($query) {
                                $query->where(function ($emptyMentorQuery) {
                                    $emptyMentorQuery->whereNull('mentor_ids')
                                        ->orWhereJsonLength('mentor_ids', 0);
                                });
                            });
                    });
            })
            ->get();
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }
}
