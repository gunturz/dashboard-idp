<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $roleName = $user->role ? strtolower(trim($user->role->role_name)) : null;


    // $roleName = $user->role ? strtolower($user->role->role_name) : null;
    
    // if ($roleName === 'talent') {


    // Redirect based on role instead of trying to show a non-existent dashboard view
    if ($roleName === 'kandidat') {
        return redirect()->route('kandidat.dashboard');
    }
    elseif ($roleName === 'talent') {
        $hasAssessed = \Illuminate\Support\Facades\DB::table('assessment_session')
            ->where('user_id_talent', $user->id)
            ->exists();
        if ($hasAssessed) {
            return redirect()->route('talent.dashboard');
        }
        else {
            return redirect()->route('talent.competency');
        }

    // $competency = null; // fallback for other roles
    // return view('dashboard', compact('user', 'competency'));
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
    elseif (in_array($roleName, ['bo_director', 'bod', 'board_of_director'])) {
        return redirect()->route('bo_director.dashboard');
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