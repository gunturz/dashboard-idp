<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\KandidatDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class , 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class , 'store']);

    // Step 2 registrasi kandidat: halaman kompetensi
    Route::get('register/kompetensi', [RegisteredUserController::class , 'stepKompetensi'])
        ->name('register.kompetensi');

    Route::post('register/kompetensi', [RegisteredUserController::class , 'storeKompetensi'])
        ->name('register.kompetensi.store');

    Route::get('login', [AuthenticatedSessionController::class , 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class , 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class , 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class , 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class , 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class , 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class , 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class , 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class , 'store']);

    Route::put('password', [PasswordController::class , 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class , 'destroy'])
        ->name('logout');



});

Route::middleware('auth')->group(function () {
    Route::get('/talent/dashboard', [\App\Http\Controllers\TalentDashboardController::class , 'index'])
        ->name('talent.dashboard');
    Route::get('/talent/competency', [\App\Http\Controllers\TalentDashboardController::class , 'competency'])
        ->name('talent.competency');
    Route::post('/talent/competency', [\App\Http\Controllers\TalentDashboardController::class , 'storeCompetency'])
        ->name('talent.competency.store');
    Route::get('/talent/idp-monitoring/{tab?}', [\App\Http\Controllers\TalentDashboardController::class , 'idpMonitoring'])
        ->name('talent.idp_monitoring');
    Route::post('/talent/idp-monitoring/{tab?}', [\App\Http\Controllers\TalentDashboardController::class , 'storeIdpMonitoring'])
        ->name('talent.idp_monitoring.store');
    Route::get('/talent/idp-monitoring/edit/{id}', [\App\Http\Controllers\TalentDashboardController::class , 'editIdpMonitoring'])
        ->name('talent.idp_monitoring.edit');
    Route::put('/talent/idp-monitoring/update/{id}', [\App\Http\Controllers\TalentDashboardController::class , 'updateIdpMonitoring'])
        ->name('talent.idp_monitoring.update');
    Route::delete('/talent/idp-monitoring/{id}', [\App\Http\Controllers\TalentDashboardController::class , 'destroyIdpMonitoring'])
        ->name('talent.idp_monitoring.destroy');
    Route::get('/talent/notifikasi', [\App\Http\Controllers\TalentDashboardController::class , 'notifikasi'])
        ->name('talent.notifikasi');
    Route::post('/talent/notifikasi/mark-all-read', [\App\Http\Controllers\TalentDashboardController::class , 'markAllNotificationsRead'])
        ->name('talent.notifikasi.markAllRead');
    Route::get('/talent/logbook', [\App\Http\Controllers\TalentDashboardController::class , 'logbookDetail'])
        ->name('talent.logbook.detail');
    Route::post('/talent/project', [\App\Http\Controllers\TalentDashboardController::class , 'storeProject'])
        ->name('talent.project.store');

    // PDC Admin Routes
    Route::get('/pdc-admin/dashboard', [\App\Http\Controllers\PDCAdminController::class , 'dashboard'])
        ->name('pdc_admin.dashboard');
    Route::get('/pdc-admin/detail/{company_id}/{position_id}', [\App\Http\Controllers\PDCAdminController::class , 'detail'])
        ->name('pdc_admin.detail');
    Route::get('/pdc-admin/talents-by-company', [\App\Http\Controllers\PDCAdminController::class , 'getTalentsByCompany'])
        ->name('pdc_admin.talents_by_company');
    Route::post('/pdc-admin/development-plan', [\App\Http\Controllers\PDCAdminController::class , 'storeDevelopmentPlan'])
        ->name('pdc_admin.development_plan.store');
    Route::get('/pdc-admin/development-plan', [\App\Http\Controllers\PDCAdminController::class , 'developmentPlan'])
        ->name('pdc_admin.development_plan');
    Route::get('/pdc-admin/talent/{talent_id}', [\App\Http\Controllers\PDCAdminController::class , 'detailTalent'])
        ->name('pdc_admin.detail.talent');
    Route::get('/pdc-admin/finance-validation', [\App\Http\Controllers\PDCAdminController::class , 'financeValidation'])
        ->name('pdc_admin.finance_validation');
    Route::patch('/pdc-admin/finance-validation/{id}', [\App\Http\Controllers\PDCAdminController::class , 'updateFinanceValidation'])
        ->name('pdc_admin.finance_validation.update');
    Route::get('/pdc-admin/kompetensi', [\App\Http\Controllers\PDCAdminController::class , 'kompetensi'])
        ->name('pdc_admin.kompetensi');
    Route::post('/pdc-admin/kompetensi/questions', [\App\Http\Controllers\PDCAdminController::class , 'updateQuestions'])
        ->name('pdc_admin.competency.update_questions');
    Route::post('/pdc-admin/kompetensi/target-scores/{position_id}', [\App\Http\Controllers\PDCAdminController::class , 'updateTargetScores'])
        ->name('pdc_admin.target_score.update');
    Route::get('/pdc-admin/mentor', [\App\Http\Controllers\PDCAdminController::class , 'mentor'])
        ->name('pdc_admin.mentor');
    Route::post('/pdc-admin/mentor/store', [\App\Http\Controllers\PDCAdminController::class , 'storeMentor'])
        ->name('pdc_admin.mentor.store');
    Route::get('/pdc-admin/atasan', [\App\Http\Controllers\PDCAdminController::class , 'atasan'])
        ->name('pdc_admin.atasan');
    Route::post('/pdc-admin/atasan/store', [\App\Http\Controllers\PDCAdminController::class , 'storeAtasan'])
        ->name('pdc_admin.atasan.store');
    Route::post('/pdc-admin/finance-validation/request', [\App\Http\Controllers\PDCAdminController::class , 'requestFinanceValidation'])
        ->name('pdc_admin.finance.request');
});
