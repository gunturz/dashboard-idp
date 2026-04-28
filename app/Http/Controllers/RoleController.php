<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function selectRole()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $roles = $user->roles;

        if ($roles->count() <= 1) {
            // If only 1 role, just redirect back to dashboard which will handle fallback
            return redirect()->route('dashboard');
        }

        return view('auth.select-role', compact('roles'));
    }

    public function setRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Verify the user actually possesses this role
        if ($user->hasRole($request->role_name)) {
            $roleName = strtolower($request->role_name);
            session(['active_role' => $roleName]);

            if (in_array($roleName, ['admin', 'pdc_admin'])) {
                session()->put('pdc_admin_just_logged_in', true);
            }
            if (in_array($roleName, ['panelis', 'bo_director', 'board_of_directors', 'board_of_director'])) {
                session()->put('panelis_just_logged_in', true);
            }
            if ($roleName === 'atasan') {
                session()->put('atasan_just_logged_in', true);
            }
            if ($roleName === 'talent') {
                session()->put('talent_just_logged_in', true);
            }
            if ($roleName === 'mentor') {
                session()->put('mentor_just_logged_in', true);
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['role_name' => 'Invalid role selected.']);
    }
}
