<?php

namespace App\Policies;

use App\Models\User;

class ProfilePolicy
{
    /**
     * User hanya boleh mengedit profil miliknya sendiri.
     * PDC Admin boleh mengedit profil siapapun.
     */
    public function update(User $currentUser, User $targetUser): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $currentUser->role?->role_name ?? '')));

        if (in_array($role, ['pdc_admin', 'admin'])) {
            return true;
        }

        return $currentUser->id === $targetUser->id;
    }

    /**
     * Hanya PDC Admin yang boleh menghapus akun user lain.
     */
    public function delete(User $currentUser, User $targetUser): bool
    {
        $role = strtolower(str_replace(' ', '_', session('active_role', $currentUser->role?->role_name ?? '')));
        return in_array($role, ['pdc_admin', 'admin']);
    }
}
