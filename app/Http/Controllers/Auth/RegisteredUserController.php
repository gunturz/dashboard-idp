<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KandidatKompetensi;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // ─── STEP 1: Tampilkan form registrasi ───────────────────────────────────

    public function create(): View
    {
        $mentors = User::where('role', 'mentor')->where('is_active', true)->get(['id', 'nama']);
        $atasans = User::where('role', 'atasan')->where('is_active', true)->get(['id', 'nama']);

        return view('auth.register', compact('mentors', 'atasans'));
    }

    // ─── STEP 1: Proses submit form registrasi ───────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username'       => ['required', 'string', 'min:3', 'max:50', 'unique:users,username', 'regex:/^[a-zA-Z0-9._-]+$/'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'nama'           => ['required', 'string', 'max:255'],
            'perusahaan'     => ['required', 'string', 'max:255'],
            'departemen'     => ['required', 'string', 'max:255'],
            'role'           => ['required', 'in:kandidat,atasan,mentor,finance,admin_pdc,bo_director'],
            'jabatan_target' => ['nullable', 'string', 'max:255'],
            'mentor_id'      => ['nullable', 'exists:users,id'],
            'atasan_id'      => ['nullable', 'exists:users,id'],
        ], [
            'username.required'   => 'Username wajib diisi.',
            'username.min'        => 'Username minimal 3 karakter.',
            'username.unique'     => 'Username sudah digunakan.',
            'username.regex'      => 'Username hanya boleh huruf, angka, titik, underscore, atau strip.',
            'password.required'   => 'Password wajib diisi.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'nama.required'       => 'Nama lengkap wajib diisi.',
            'perusahaan.required' => 'Perusahaan wajib dipilih.',
            'departemen.required' => 'Departemen wajib dipilih.',
            'role.required'       => 'Role wajib dipilih.',
            'role.in'             => 'Role yang dipilih tidak valid.',
        ]);

        // Jika role = kandidat → simpan ke session, lanjut ke step kompetensi
        if ($request->role === 'kandidat') {
            session([
                'register_data' => [
                    'nama'           => $request->nama,
                    'username'       => $request->username,
                    'password'       => $request->password, // di-hash di step terakhir
                    'role'           => 'kandidat',
                    'perusahaan'     => $request->perusahaan,
                    'departemen'     => $request->departemen,
                    'jabatan'        => $request->jabatan ?? null,
                    'jabatan_target' => $request->jabatan_target ?? null,
                    'mentor_id'      => $request->mentor_id ?? null,
                    'atasan_id'      => $request->atasan_id ?? null,
                ],
            ]);

            return redirect()->route('register.kompetensi');
        }

        // Role selain kandidat → buat user langsung
        $user = User::create([
            'nama'           => $request->nama,
            'username'       => $request->username,
            'email'          => $request->email ?? null,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            'perusahaan'     => $request->perusahaan,
            'departemen'     => $request->departemen,
            'jabatan'        => $request->jabatan ?? null,
            'jabatan_target' => null,
            'mentor_id'      => null,
            'atasan_id'      => null,
            'is_active'      => true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return match($user->role) {
            'atasan'      => redirect()->route('atasan.dashboard'),
            'mentor'      => redirect()->route('mentor.dashboard'),
            'finance'     => redirect()->route('finance.dashboard'),
            'admin_pdc'   => redirect()->route('admin_pdc.dashboard'),
            'bo_director' => redirect()->route('bo_director.dashboard'),
            default       => redirect('/'),
        };
    }

    // ─── STEP 2: Tampilkan form kompetensi ───────────────────────────────────

    public function stepKompetensi(): View|RedirectResponse
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register')
                ->withErrors(['role' => 'Sesi registrasi habis. Silakan ulangi.']);
        }

        $kompetensi = KandidatKompetensi::labels();
        $levels     = KandidatKompetensi::levels();

        return view('auth.kompetensi', compact('kompetensi', 'levels'));
    }

    // ─── STEP 2: Proses submit kompetensi → buat user + simpan kompetensi ────

    public function storeKompetensi(Request $request): RedirectResponse
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register')
                ->withErrors(['role' => 'Sesi registrasi habis. Silakan ulangi.']);
        }

        $columns = array_keys(KandidatKompetensi::labels());
        $labels  = array_values(KandidatKompetensi::labels());

        $rules = [];
        foreach ($columns as $col) {
            $rules[$col] = ['required', 'integer', 'min:1', 'max:5'];
        }

        $messages = [];
        foreach ($columns as $i => $col) {
            $messages["$col.required"] = "\"{$labels[$i]}\" wajib dipilih.";
        }

        $request->validate($rules, $messages);

        $data = session('register_data');

        // Buat user kandidat
        $user = User::create([
            'nama'           => $data['nama'],
            'username'       => $data['username'],
            'email'          => $data['email'] ?? null,
            'password'       => Hash::make($data['password']),
            'role'           => 'kandidat',
            'perusahaan'     => $data['perusahaan'],
            'departemen'     => $data['departemen'],
            'jabatan'        => $data['jabatan'] ?? null,
            'jabatan_target' => $data['jabatan_target'] ?? null,
            'mentor_id'      => $data['mentor_id'] ?? null,
            'atasan_id'      => $data['atasan_id'] ?? null,
            'is_active'      => true,
        ]);

        // Simpan data kompetensi
        $kompetensiData = ['user_id' => $user->id];
        foreach ($columns as $col) {
            $kompetensiData[$col] = (int) $request->input($col);
        }
        KandidatKompetensi::create($kompetensiData);

        session()->forget('register_data');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('kandidat.dashboard');
    }
}
