<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;

class User extends Authenticatable implements HasName, FilamentUser
{
    use HasFactory, Notifiable;

    public function getFilamentName(): string
    {
        return $this->nama ?? 'Unknown';
    }

    /**
     * Hanya user dengan role admin_pdc yang boleh akses panel Filament.
     * Method ini dipanggil otomatis oleh middleware Filament saat akses /admin-pdc.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if (!$this->role) {
            return false;
        }
        $roleName = strtolower(trim($this->role->role_name));
        return in_array($roleName, ['admin_pdc', 'pdc admin', 'pdc_admin', 'admin.pdc']);
    }

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
}
