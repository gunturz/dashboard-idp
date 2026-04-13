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

// API: fetch departments filtered by company — accessible to both guest and logged-in users
Route::get('register/departments', [\App\Http\Controllers\Auth\RegisteredUserController::class , 'getDepartmentsByCompany'])
    ->name('register.departments_by_company');

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
    Route::get('/talent/logbook-item/{id}', [\App\Http\Controllers\TalentDashboardController::class , 'logbookItemDetail'])
        ->name('talent.logbook.item');
    Route::post('/talent/project', [\App\Http\Controllers\TalentDashboardController::class , 'storeProject'])
        ->name('talent.project.store');

    // PDC Admin Routes
    Route::get('/pdc-admin/dashboard', [\App\Http\Controllers\PDCAdminController::class , 'dashboard'])
        ->name('pdc_admin.dashboard');
    Route::get('/pdc-admin/progress-talent', [\App\Http\Controllers\PDCAdminController::class , 'progressTalent'])
        ->name('pdc_admin.progress_talent');
    Route::get('/pdc-admin/notifikasi', [\App\Http\Controllers\PDCAdminController::class , 'notifikasi'])
        ->name('pdc_admin.notifikasi');
    Route::post('/pdc-admin/notifikasi/mark-all-read', [\App\Http\Controllers\PDCAdminController::class , 'markAllNotificationsRead'])
        ->name('pdc_admin.notifikasi.markAllRead');
    Route::get('/pdc-admin/detail/{company_id}/{position_id}', [\App\Http\Controllers\PDCAdminController::class , 'detail'])
        ->name('pdc_admin.detail');
    Route::get('/pdc-admin/talents-by-company', [\App\Http\Controllers\PDCAdminController::class , 'getTalentsByCompany'])
        ->name('pdc_admin.talents_by_company');
    Route::post('/pdc-admin/top-gaps/{talent_id}', [\App\Http\Controllers\PDCAdminController::class , 'updateTopGaps'])
        ->name('pdc_admin.top_gaps.update');
    Route::post('/pdc-admin/development-plan', [\App\Http\Controllers\PDCAdminController::class , 'storeDevelopmentPlan'])
        ->name('pdc_admin.development_plan.store');
    Route::get('/pdc-admin/development-plan', [\App\Http\Controllers\PDCAdminController::class , 'developmentPlan'])
        ->name('pdc_admin.development_plan');
    Route::get('/pdc-admin/talent/{talent_id}', [\App\Http\Controllers\PDCAdminController::class , 'detailTalent'])
        ->name('pdc_admin.detail.talent');
    Route::get('/pdc-admin/logbook-detail/{id}', [\App\Http\Controllers\PDCAdminController::class , 'logbookDetail'])
        ->name('pdc_admin.logbook.detail');
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
    Route::get('/pdc-admin/user-management', [\App\Http\Controllers\PDCAdminController::class , 'user_management'])
        ->name('pdc_admin.user_management');
    Route::post('/pdc-admin/assign-role/{id}', [\App\Http\Controllers\PDCAdminController::class , 'assignRole'])
        ->name('pdc_admin.assign_role');
    Route::post('/pdc-admin/reset-password/{id}', [\App\Http\Controllers\PDCAdminController::class , 'resetPassword'])
        ->name('pdc_admin.reset_password');
    // Company Management
    Route::get('/pdc-admin/company-management', [\App\Http\Controllers\PDCAdminController::class , 'companyManagement'])
        ->name('pdc_admin.company_management');
    Route::post('/pdc-admin/company', [\App\Http\Controllers\PDCAdminController::class , 'storeCompany'])
        ->name('pdc_admin.company.store');
    Route::put('/pdc-admin/company/{id}', [\App\Http\Controllers\PDCAdminController::class , 'updateCompany'])
        ->name('pdc_admin.company.update');
    Route::delete('/pdc-admin/company/{id}', [\App\Http\Controllers\PDCAdminController::class , 'destroyCompany'])
        ->name('pdc_admin.company.destroy');
    Route::get('/pdc-admin/company/{id}/departments', [\App\Http\Controllers\PDCAdminController::class , 'departmentManagement'])
        ->name('pdc_admin.company.departments');
    Route::post('/pdc-admin/department', [\App\Http\Controllers\PDCAdminController::class , 'storeDepartment'])
        ->name('pdc_admin.department.store');
    Route::put('/pdc-admin/department/{id}', [\App\Http\Controllers\PDCAdminController::class , 'updateDepartment'])
        ->name('pdc_admin.department.update');
    Route::delete('/pdc-admin/department/{id}', [\App\Http\Controllers\PDCAdminController::class , 'destroyDepartment'])
        ->name('pdc_admin.department.destroy');
    Route::post('/pdc-admin/finance-validation/request', [\App\Http\Controllers\PDCAdminController::class , 'requestFinanceValidation'])
        ->name('pdc_admin.finance.request');
    Route::get('/pdc-admin/export', [\App\Http\Controllers\PDCAdminController::class , 'export'])
        ->name('pdc_admin.export');

    Route::get('/pdc-admin/panelis-review', [\App\Http\Controllers\PDCAdminController::class , 'panelisReview'])
        ->name('pdc_admin.panelis_review');
    Route::post('/pdc-admin/panelis-review/send/{talent_id}', [\App\Http\Controllers\PDCAdminController::class , 'sendPanelisReview'])
        ->name('pdc_admin.panelis_review.send');
    Route::get('/pdc-admin/panelis-review/{talent_id}', [\App\Http\Controllers\PDCAdminController::class , 'panelisReviewDetail'])
        ->name('pdc_admin.panelis_review.detail');
    Route::post('/pdc-admin/panelis-review/{talent_id}/complete', [\App\Http\Controllers\PDCAdminController::class , 'panelisReviewComplete'])
        ->name('pdc_admin.panelis_review.complete');
    Route::post('/pdc-admin/panelis-review/{talent_id}/toggle-lock', [\App\Http\Controllers\PDCAdminController::class , 'toggleLock'])
        ->name('pdc_admin.panelis_review.toggle_lock');
    Route::get('/pdc-admin/talent/{talent_id}/export-pdf', [\App\Http\Controllers\PDCAdminController::class , 'exportPdf'])
        ->name('pdc_admin.export_pdf');

    // Atasan Routes
    Route::get('/atasan/dashboard', [\App\Http\Controllers\AtasanDashboardController::class , 'dashboard'])
        ->name('atasan.dashboard');
    Route::get('/atasan/notifikasi', [\App\Http\Controllers\AtasanDashboardController::class , 'notifikasi'])
        ->name('atasan.notifikasi');
    Route::post('/atasan/notifikasi/mark-all-read', [\App\Http\Controllers\AtasanDashboardController::class , 'markAllNotificationsRead'])
        ->name('atasan.notifikasi.markAllRead');
    Route::get('/atasan/monitoring', [\App\Http\Controllers\AtasanDashboardController::class , 'monitoring'])
        ->name('atasan.monitoring');
    Route::get('/atasan/competency_atasan/{talentId}', [\App\Http\Controllers\AtasanDashboardController::class , 'assessmentPage'])
        ->name('atasan.competency_atasan.page');
    Route::post('/atasan/competency_atasan/{talentId}', [\App\Http\Controllers\AtasanDashboardController::class , 'storeAssessment'])
        ->name('atasan.competency_atasan.store');
    Route::get('/atasan/logbook-item/{id}', [\App\Http\Controllers\AtasanDashboardController::class , 'logbookItemDetail'])
        ->name('atasan.logbook.detail');

    // Mentor Routes
    Route::get('/mentor/dashboard', [\App\Http\Controllers\MentorDashboardController::class , 'dashboard'])
        ->name('mentor.dashboard');
    Route::get('/mentor/notifikasi', [\App\Http\Controllers\MentorDashboardController::class , 'notifikasi'])
        ->name('mentor.notifikasi');
    Route::post('/mentor/notifikasi/mark-all-read', [\App\Http\Controllers\MentorDashboardController::class , 'markAllNotificationsRead'])
        ->name('mentor.notifikasi.markAllRead');
    Route::get('/mentor/logbook', [\App\Http\Controllers\MentorDashboardController::class , 'logbook'])
        ->name('mentor.logbook');
    Route::post('/mentor/logbook/{id}/status', [\App\Http\Controllers\MentorDashboardController::class , 'updateLogbookStatus'])
        ->name('mentor.logbook.update_status');
    Route::get('/mentor/logbook-item/{id}', [\App\Http\Controllers\MentorDashboardController::class , 'logbookItemDetail'])
        ->name('mentor.logbook.detail');

    // Finance Routes
    Route::get('/finance/dashboard', [\App\Http\Controllers\FinanceDashboardController::class , 'dashboard'])
        ->name('finance.dashboard');
    Route::get('/finance/riwayat', [\App\Http\Controllers\FinanceDashboardController::class , 'riwayat'])
        ->name('finance.riwayat');
    Route::get('/finance/permintaan-validasi', [\App\Http\Controllers\FinanceDashboardController::class , 'permintaanValidasi'])
        ->name('finance.permintaan_validasi');
    Route::patch('/finance/permintaan-validasi/{id}', [\App\Http\Controllers\FinanceDashboardController::class , 'updateFinanceValidation'])
        ->name('finance.permintaan_validasi.update');
    Route::get('/finance/notifikasi', [\App\Http\Controllers\FinanceDashboardController::class , 'notifikasi'])
        ->name('finance.notifikasi');
    Route::post('/finance/notifikasi/mark-all-read', [\App\Http\Controllers\FinanceDashboardController::class , 'markAllNotificationsRead'])
        ->name('finance.notifikasi.markAllRead');

    // Panelis Routes
    Route::get('/panelis/dashboard', [\App\Http\Controllers\PanelisController::class , 'dashboard'])
        ->name('panelis.dashboard');
    Route::get('/panelis/review', [\App\Http\Controllers\PanelisController::class , 'review'])
        ->name('panelis.review');
    Route::get('/panelis/history', [\App\Http\Controllers\PanelisController::class , 'history'])
        ->name('panelis.history');
    Route::get('/panelis/talent/{talent_id}', [\App\Http\Controllers\PanelisController::class , 'detailTalent'])
        ->name('panelis.detail_talent');
    Route::get('/panelis/talent/{talent_id}/penilaian', [\App\Http\Controllers\PanelisController::class , 'penilaian'])
        ->name('panelis.penilaian');
    Route::post('/panelis/talent/{talent_id}/penilaian', [\App\Http\Controllers\PanelisController::class , 'simpanPenilaian'])
        ->name('panelis.penilaian.simpan');
    Route::get('/panelis/talent/{talent_id}/logbook', [\App\Http\Controllers\PanelisController::class , 'logbook'])
        ->name('panelis.logbook');
    Route::get('/panelis/notifikasi', [\App\Http\Controllers\PanelisController::class , 'notifikasi'])
        ->name('panelis.notifikasi');
    Route::post('/panelis/notifikasi/mark-all-read', [\App\Http\Controllers\PanelisController::class , 'markAllNotificationsRead'])
        ->name('panelis.notifikasi.markAllRead');
    Route::get('/panelis/profile', [\App\Http\Controllers\ProfileController::class , 'edit'])
        ->name('panelis.profile');
});
