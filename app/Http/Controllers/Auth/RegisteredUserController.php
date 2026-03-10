<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $mentors = User::whereHas('role', fn($q) => $q->where('role_name', 'mentor'))->get();
        $atasans = User::whereHas('role', fn($q) => $q->where('role_name', 'atasan'))->get();
        $companies = DB::table('company')->get();
        $departments = DB::table('department')->get();
        $roles = DB::table('role')->whereNotIn('role_name', ['admin_pdc'])->get();
        $positions = DB::table('position')
            ->whereNotIn('position_name', ['Super Admin'])
            ->get();
        $targetPositions = DB::table('position')
            ->whereNotIn('position_name', ['Super Admin', 'Board of Directors'])
            ->get();

        return view('auth.register', compact('mentors', 'atasans', 'companies', 'departments', 'roles', 'positions', 'targetPositions'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'exists:company,id'],
            'department_id' => ['required', 'exists:department,id'],
            'position_id' => ['required', 'exists:position,id'],
            'role_id' => ['required', 'exists:role,id'],
            'jabatan_target' => ['nullable', 'exists:position,id'],
            'mentor_id' => ['nullable', 'exists:users,id'],
            'atasan_id' => ['nullable', 'exists:users,id'],
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat User Baru
            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company_id' => $request->company_id,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'role_id' => $request->role_id,
                'mentor_id' => $request->mentor_id,
                'atasan_id' => $request->atasan_id,
            ]);

            // 2. Hubungkan User dengan tabel user_role
            DB::table('user_role')->insert([
                'id_user' => $user->id,
                'id_role' => $request->role_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Cek apakah rolenya adalah talent
            $isTalent = DB::table('role')
                ->where('id', $request->role_id)
                ->whereIn('role_name', ['talent', 'Talent'])
                ->exists();

            // 3. Tambahkan ke promotion_plan (IDP) jika dia Talent & punya target jabatan
            if ($isTalent && $request->jabatan_target) {
                DB::table('promotion_plan')->insert([
                    'user_id_talent' => $user->id,
                    'target_position_id' => $request->jabatan_target,
                    'status_promotion' => 'Draft',
                    'start_date' => now(),
                    'target_date' => now()->addYear(), // Target otomatis 1 tahun ke depan
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            event(new Registered($user));

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('status', 'Pendaftaran akun berhasil! Silakan masuk.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['email' => 'Proses pendaftaran gagal: ' . $e->getMessage()]);
        }
    }
}