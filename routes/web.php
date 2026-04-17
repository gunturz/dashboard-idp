<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

Route::get('/role/select', [\App\Http\Controllers\RoleController::class , 'selectRole'])
    ->middleware(['auth', 'verified'])->name('role.select');
Route::post('/role/set', [\App\Http\Controllers\RoleController::class , 'setRole'])
    ->middleware(['auth', 'verified'])->name('role.set');

Route::get('/dashboard', function () {
    $user = auth()->user();

    // Attempt to get active role from session, otherwise fallback to primary role
    $roleName = session('active_role');
    if (!$roleName) {
        $roles = $user->roles;
        if ($roles && $roles->count() > 1) {
            return redirect()->route('role.select');
        }
        elseif ($roles && $roles->count() === 1) {
            $roleName = strtolower(trim($roles->first()->role_name));
            session(['active_role' => $roleName]);
        }
        else {
            $roleName = $user->role ? strtolower(trim($user->role->role_name)) : null;
        }
    }

    // Redirect based on role instead of trying to show a non-existent dashboard view
    if ($roleName === 'kandidat') {
        return redirect()->route('kandidat.dashboard');
    }
    elseif ($roleName === 'talent') {
        return redirect()->route('talent.dashboard');
    }
    elseif ($roleName === 'atasan') {
        return redirect()->route('atasan.dashboard');
    }
    elseif ($roleName === 'mentor') {
        return redirect()->route('mentor.dashboard');
    }
    elseif ($roleName === 'finance') {
        return redirect()->route('finance.dashboard');
    }
    elseif (in_array($roleName, ['admin', 'pdc admin', 'pdc_admin'])) {
        return redirect()->route('pdc_admin.dashboard');
    }
    elseif (in_array($roleName, ['Panelis', 'panelis', 'panelist', 'Panelist'])) {
        return redirect()->route('panelis.dashboard');
    }

    // Fallback
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route profile (edit)
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
