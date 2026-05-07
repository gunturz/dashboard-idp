<?php

namespace App\Policies;

use App\Models\User;

class TalentDataPolicy
{
    /**
     * Siapa yang boleh melihat detail data talent tertentu?
     *
     * - PDC Admin: semua talent
     * - Panelis: hanya talent yang di-assign
     * - Atasan: hanya bawahan langsungnya
     * - Mentor: hanya mentee-nya
     * - Talent: hanya dirinya sendiri
     * - Finance: tidak ada akses profil talent
     */
    public function view(User $viewer, User $talent): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $viewer->role?->role_name ?? '')));

        return match(true) {
            in_array($role, ['pdc_admin', 'admin']) => true,
            $role === 'talent'   => $viewer->id === $talent->id,
            $role === 'atasan'   => $viewer->bawahanTalents()->where('id', $talent->id)->exists(),
            $role === 'mentor'   => $viewer->mentees()->where('id', $talent->id)->exists(),
            $role === 'panelis'  => \App\Models\PanelisAssessment::where('panelis_id', $viewer->id)
                                        ->where('user_id_talent', $talent->id)->exists(),
            default              => false,
        };
    }

    /**
     * Hanya PDC Admin yang boleh melakukan bulk delete / export semua talent.
     */
    public function manageAll(User $user): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $user->role?->role_name ?? '')));
        return in_array($role, ['pdc_admin', 'admin']);
    }
}
