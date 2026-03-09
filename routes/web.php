<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KandidatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    // Jika kandidat, arahkan ke dashboard khusus kandidat
    if ($user->role === 'kandidat') {
        return redirect()->route('kandidat.dashboard');
    }
    $kompetensi = $user->kandidatKompetensi ?? null;
    return view('dashboard', compact('user', 'kompetensi'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route profile (kandidat dashboard & edit)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route kandidat dashboard
    Route::get('/kandidat/dashboard', [KandidatController::class, 'dashboard'])->name('kandidat.dashboard');
    Route::get('/kandidat/notifikasi', [KandidatController::class, 'notifikasi'])->name('kandidat.notifikasi');
});

require __DIR__ . '/auth.php';