<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PdcPanelisReview; // Model assignment panelis

class PenilaianPolicy
{
    /**
     * Hanya panelis yang di-assign ke talent tersebut yang boleh submit penilaian.
     */
    public function submit(User $user, int $talentId): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $user->role?->role_name ?? '')));

        if (! in_array($role, ['panelis', 'panelist'])) {
            return false;
        }

        // Cek apakah panelis ini benar-benar di-assign ke talent tersebut
        return PdcPanelisReview::where('panelis_id', $user->id)
            ->where('talent_id', $talentId)
            ->exists();
    }

    /**
     * Hanya PDC Admin yang boleh melihat semua penilaian.
     */
    public function viewAll(User $user): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $user->role?->role_name ?? '')));
        return in_array($role, ['pdc_admin', 'admin']);
    }
}
