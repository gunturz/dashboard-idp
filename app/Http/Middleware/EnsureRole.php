<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Memastikan user yang login memiliki salah satu role yang diizinkan.
     *
     * @param array<string> $roles  role yang diizinkan (bisa lebih dari satu)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $allowed = array_map(fn($r) => strtolower(str_replace(' ', '_', trim($r))), $roles);

        // Ambil role aktif dari session (mendukung multi-role)
        $activeRole = strtolower(trim(session('active_role', '')));
        if ($activeRole !== '') {
            $activeRole = str_replace(' ', '_', $activeRole);
            if (in_array($activeRole, $allowed, true)) {
                return $next($request);
            }
        }

        // Jika session kosong, cek seluruh role user murni dari DB
        $userRoles = [];

        // Cek many-to-many relationship
        if ($request->user()->roles) {
            foreach ($request->user()->roles as $rl) {
                $userRoles[] = strtolower(str_replace(' ', '_', trim($rl->role_name)));
            }
        }

        // Cek directly dari role_id (fallback)
        if ($request->user()->role) {
            $userRoles[] = strtolower(str_replace(' ', '_', trim($request->user()->role->role_name)));
        }

        foreach ($userRoles as $uRole) {
            if (in_array($uRole, $allowed, true)) {
                // Diizinkan karena user beneran punya role ini di DB
                return $next($request);
            }
        }

        \Illuminate\Support\Facades\Log::error("EnsureRole 403 triggered.", [
            'raw_session' => session('active_role'),
            'user_roles_db' => $userRoles,
            'allowed_roles' => $allowed,
            'user_id' => $request->user()->id
        ]);

        // Jika role tidak cocok → abort 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
