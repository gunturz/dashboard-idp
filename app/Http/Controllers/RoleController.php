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
            session(['active_role' => strtolower($request->role_name)]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['role_name' => 'Invalid role selected.']);
    }
}
