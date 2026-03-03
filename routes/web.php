<?php

use App\Http\Controllers\ProfileController;
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
    // Untuk role lain, tampilkan dashboard umum dengan data yang diperlukan
    $kompetensi = $user->kandidatKompetensi ?? null;
    return view('dashboard', compact('user', 'kompetensi'));
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
