<?php

namespace App\Policies;

use App\Models\User;
use App\Models\IdpActivity;

class FilePolicy
{
    /**
     * Apakah user boleh melihat/download file tertentu?
     * 
     * Aturan:
     * - Talent: hanya file milik diri sendiri
     * - Atasan: file milik talent yang dia supervisi
     * - Mentor: file milik mentee-nya
     * - PDC Admin & Panelis: semua file
     * - Finance: tidak ada akses file IDP
     */
    public function view(User $user, IdpActivity $activity): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $user->role?->role_name ?? '')));

        return match(true) {
            in_array($role, ['pdc_admin', 'admin', 'panelis', 'panelist']) => true,
            $role === 'talent'  => $activity->talent_id === $user->id,
            $role === 'atasan'  => $user->bawahanTalents()->where('id', $activity->talent_id)->exists(),
            $role === 'mentor'  => $user->mentees()->where('id', $activity->talent_id)->exists(),
            default             => false,
        };
    }
}
