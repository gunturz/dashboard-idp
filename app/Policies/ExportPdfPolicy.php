<?php

namespace App\Policies;

use App\Models\User;

class ExportPdfPolicy
{
    /**
     * Siapa yang boleh export PDF talent?
     * - PDC Admin: boleh export PDF semua talent
     * - Atasan: boleh export PDF bawahannya
     * - Talent sendiri: boleh export PDF dirinya
     * - Role lain: tidak boleh
     */
    public function export(User $user, User $talent): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $user->role?->role_name ?? '')));

        return match(true) {
            in_array($role, ['pdc_admin', 'admin']) => true,
            $role === 'talent'  => $user->id === $talent->id,
            $role === 'atasan'  => $user->bawahanTalents()->where('id', $talent->id)->exists(),
            default             => false,
        };
    }
}
