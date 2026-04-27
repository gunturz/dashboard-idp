<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\IdpActivity;
use App\Models\ImprovementProject;
use App\Models\User;

class TalentDashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'promotion_plan.targetPosition', 'mentor', 'atasan']);

            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses dashboard ini.');
            }

            $notifications = $this->getNotifications();

            return view('talent.dashboard', compact(
                'user',
                'notifications'
            ));
        }
        catch (\Exception $e) {
            Log::error('talentDashboard error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function competency()
    {
        try {
            $user = Auth::user()->load(['promotion_plan.targetPosition']);
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent yang bisa mengakses halaman ini.');
            }

            $competencies = \App\Models\Competence::with(['questions' => function ($q) {
                $q->orderBy('level');
            }])->get();

            // Ambil target level per kompetensi sesuai posisi yang dituju talent
            $targetPositionId = optional($user->promotion_plan)->target_position_id;
            $targetLevels = [];
            if ($targetPositionId) {
                $targetLevels = \App\Models\PositionTargetCompetence::where('position_id', $targetPositionId)
                    ->pluck('target_level', 'competence_id')
                    ->toArray();
            }

            return view('talent.competency', compact('user', 'competencies', 'targetLevels'));
        }
        catch (\Exception $e) {
            Log::error('talent competency error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function storeCompetency(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent yang bisa mengakses halaman ini.');
            }

            if (optional($user->promotion_plan)->is_locked) {
                return back()->with('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            }

            // Validasi Input Array Score dari request POST
            // min:0 karena Level 1 + Ragu-ragu = skor 0
            $data = $request->validate([
                'scores' => 'required|array',
                'scores.*' => 'required|integer|min:0|max:5',
            ]);

            DB::beginTransaction();

            $bulanTahun = now()->format('F Y');
            $userIdAtasan = $user->atasan_id ?: null;

            // 1. Buat Header / Sesi Assessment Baru
            $assessmentId = DB::table('assessment_session')->insertGetId([
                'user_id_talent' => $user->id,
                'user_id_atasan' => $userIdAtasan,
                'period' => "Assessment {$bulanTahun}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Siapkan Data Multiple Detail Assessment untuk di-insert
            $details = [];
            foreach ($data['scores'] as $competenceId => $scoreTalent) {
                $details[] = [
                    'assessment_id' => $assessmentId,
                    'competence_id' => (int)$competenceId,
                    'score_atasan' => 0, // diisi nanti oleh Atasan
                    'score_talent' => (int)$scoreTalent,
                    'gap_score' => 0, // diisi nanti
                    'notes' => 'Completed by talent',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 3. Batch Insert ke tabel detail_assessment
            DB::table('detail_assessment')->insert($details);

            DB::commit();

            return redirect()->route('talent.dashboard')
                ->with('success', 'Berhasil! Penilaian kompetensi Anda telah tersimpan.');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()
                ->with('error', 'Data assessment tidak valid. Pastikan semua kompetensi sudah dinilai.');
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('talent store competency error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses penilaian kompetensi: ' . $e->getMessage());
        }
    }

    public function idpMonitoring($tab = 'exposure')
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan', 'promotion_plan']);
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses halaman ini.');
            }

            // Ambil mentor dari promotion plan (multiple mentors)
            $mentors = $user->promotion_plan ? $user->promotion_plan->mentor_models : collect();
            $atasans = $user->atasan ? collect([$user->atasan]) : collect();

            $notifications = $this->getNotifications();

            return view('talent.idp-monitoring', compact('user', 'tab', 'mentors', 'atasans', 'notifications'));
        }
        catch (\Exception $e) {
            Log::error('talentDashboard idpMonitoring error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function storeIdpMonitoring(Request $request, $tab = 'exposure')
    {
        try {
            $user = Auth::user();
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses halaman ini.');
            }

            if (optional($user->promotion_plan)->is_locked) {
                return back()->with('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            }

            // ── Validasi input ──────────────────────────────────────────────
            $rules = [
                'theme' => 'required|string|max:255',
                'activity_date' => 'required|date',
                'documents' => 'nullable|array|max:5', // maks 5 file
                'documents.*' => 'file|max:5120|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx',
            ];

            if ($tab === 'learning') {
                $rules['activity'] = 'required|string|max:255';
                $rules['platform'] = 'required|string|max:255';
            }
            else {
                $rules['mentor_name'] = 'required|string|max:255';
                $rules['location'] = 'required|string|max:255';
            }

            if ($tab === 'mentoring') {
                $rules['description'] = 'required|string';
                $rules['action_plan'] = 'required|string';
            }
            elseif ($tab === 'exposure') {
                $rules['activity'] = 'required|string';
                $rules['description'] = 'required|string';
            }

            // Merge activity and description based on tab
            $tab_from_request = $request->input('tab_type', $tab);
            if ($tab_from_request === 'learning') {
                $request->merge(['activity' => $request->input('activity_learning')]);
            }
            elseif ($tab_from_request === 'exposure') {
                $request->merge([
                    'activity' => $request->input('activity_exposure'),
                    'description' => $request->input('description_exposure')
                ]);
            }
            elseif ($tab_from_request === 'mentoring') {
                $request->merge(['description' => $request->input('description_mentoring')]);
            }

            $validated = $request->validate($rules, [
                'documents.max' => 'Maksimal 5 file yang bisa diupload.',
                'documents.*.max' => 'Ukuran setiap file tidak boleh melebihi 5 MB.',
                'documents.*.mimes' => 'Format file harus: PNG, JPG, PDF, DOC, DOCX, XLS, XLSX.',
            ]);

            // Gunakan tab dari request jika ada
            $tab = $tab_from_request;

            // ── Type IDP ────────────────────────────────────────────────────
            $typeId = DB::table('idp_type')->where('type_name', ucfirst($tab))->value('id');
            if (!$typeId) {
                return back()->with('error', 'Tipe IDP tidak valid.');
            }

            // ── Upload file(s) ──────────────────────────────────────────────
            $documentPaths = [];
            $fileNames = [];

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $fileNames[] = $file->getClientOriginalName();
                    $documentPaths[] = $file->store('idp_documents', 'public');
                }
            }

            $documentPath = count($documentPaths) === 1
                ? $documentPaths[0] // satu file → simpan string biasa
                 : (count($documentPaths) > 1 ? json_encode($documentPaths) : ''); // banyak → JSON

            $fileName = count($fileNames) === 1
                ? $fileNames[0]
                : (count($fileNames) > 1 ? implode(', ', $fileNames) : null);

            // ── Verify by (mentor) ──────────────────────────────────────────
            $verifyById = null;
            if ($request->filled('mentor_name')) {
                $verifyById = User::where('nama', $request->mentor_name)->value('id');
            }

            // ── Simpan ke DB ────────────────────────────────────────────────
            IdpActivity::create([
                'user_id_talent' => $user->id,
                'type_idp' => $typeId,
                'verify_by' => $verifyById,
                'theme' => $validated['theme'],
                'activity_date' => $validated['activity_date'],
                'location' => $request->location ?? '',
                'activity' => $request->activity ?? '',
                'description' => $request->description ?? '',
                'action_plan' => $request->action_plan ?? '',
                'document_path' => $documentPath,
                'file_name' => $fileName,
                'status' => 'Pending',
                'platform' => $request->platform ?? '',
            ]);

            // Tambahkan notifikasi ke Talent
            $this->addNotificationToUser(
                $user->id,
                'Submit IDP Berhasil',
                'Formulir <span class="font-semibold">' . ucfirst($tab) . '</span> dengan tema <span class="font-semibold">' . $validated['theme'] . '</span> telah berhasil dikirim dan sedang menunggu tinjauan dari mentor/atasan.',
                'success'
            );

            // Tambahkan notifikasi ke Verifikator (Mentor)
            if ($verifyById) {
                $this->addNotificationToUser(
                    $verifyById,
                    'IDP Activity Baru',
                    $user->nama . ' telah mengirimkan aktivitas IDP baru (<span class="font-semibold">' . ucfirst($tab) . '</span>) untuk diverifikasi.',
                    'info'
                );
            }

            return redirect()->route('talent.idp_monitoring', $tab)->with('success', 'IDP Activity berhasil disubmit.');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
        catch (\Exception $e) {
            Log::error('talentDashboard storeIdpMonitoring error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function storeProject(Request $request)
    {
        try {
            $user = Auth::user();
            if (optional($user->promotion_plan)->is_locked) {
                return back()->with('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            }

            $request->validate([
                'judul_project' => 'required|string|max:255',
                'project_file' => 'required|file|max:10240|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
            ], [
                'judul_project.required' => 'Judul project harus diisi.',
                'project_file.required' => 'File project harus diunggah.',
                'project_file.max' => 'Ukuran file tidak boleh melebihi 10 MB.',
                'project_file.mimes' => 'Format file tidak didukung.',
            ]);

            $documentPath = $request->file('project_file')
                ->store('improvement_projects', 'public');

            ImprovementProject::create([
                'user_id_talent' => Auth::id(),
                'title' => $request->judul_project,
                'document_path' => $documentPath,
                'status' => 'Pending',
            ]);

            // Tambahkan notifikasi ke akun Talent sendri
            $this->addNotificationToUser(
                Auth::id(),
                'Submit Project Improvement Berhasil',
                'Project Improvement berjudul <span class="font-semibold">' . e($request->judul_project) . '</span> telah berhasil disubmit dan sedang menunggu tinjauan.',
                'success'
            );

            return redirect(route('talent.dashboard') . '#Project Improvement')
                ->with('success_project', 'Project Improvement berhasil disubmit.');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
        catch (\Exception $e) {
            Log::error('storeProject error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan project.');
        }
    }

    // public function riwayat()
    // {
    //     $user = Auth::user();

    //     $talent = User::with([
    //         'company',
    //         'department',
    //         'position',
    //         'mentor',
    //         'atasan',
    //         'promotion_plan.targetPosition',
    //         'assessmentSession.details.competence',
    //         'idpActivities.type',
    //         'improvementProjects.verifier',
    //         'panelisAssessments.panelis.company',
    //     ])->findOrFail($user->id);

    //     $competencies = \App\Models\Competence::all();

    //     $positionId = optional($talent->promotion_plan)->target_position_id;
    //     $standards = $positionId
    //         ?\App\Models\PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
    //         : collect();

    //     // Build top 3 GAP list
    //     $sess = $talent->assessmentSession;
    //     $gaps = collect();
    //     if ($sess && $sess->details->count()) {
    //         $overrides = $sess->details->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))
    //             ->sortBy(fn($d) => (int)explode('|', str_replace('priority_', '', $d->notes))[0]);
    //         $gaps = $overrides->count() > 0
    //             ? $overrides->values()
    //             : $sess->details->sortBy('gap_score')->take(3)->values();
    //     }

    //     // IDP activity counts
    //     $exposureCount = 0;
    //     $mentoringCount = 0;
    //     $learningCount = 0;
    //     if ($talent->idpActivities) {
    //         foreach ($talent->idpActivities as $act) {
    //             $typeName = strtolower(optional($act->type)->type_name ?? '');
    //             if (str_contains($typeName, 'exposure'))
    //                 $exposureCount++;
    //             elseif (str_contains($typeName, 'mentor'))
    //                 $mentoringCount++;
    //             elseif (str_contains($typeName, 'learn'))
    //                 $learningCount++;
    //         }
    //     }

    //     $notifications = $this->getNotifications();

    //     return view('talent.riwayat', compact(
    //         'user',
    //         'talent',
    //         'competencies',
    //         'standards',
    //         'gaps',
    //         'exposureCount',
    //         'mentoringCount',
    //         'learningCount',
    //         'notifications'
    //     ));
    // }

    public function notifikasi()
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        return view('talent.notifikasi', compact('user', 'notifications'));
    }



    public function logbookDetail()
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan']);
        $notifications = $this->getNotifications();

        $activities = \App\Models\IdpActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $user->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $exposureData = [];
        $mentoringData = [];
        $learningData = [];

        foreach ($activities as $act) {
            $typeName = $act->type ? $act->type->type_name : '';

            // Build array of all file paths and their names
            $docPaths = [];
            $docNames = [];
            if ($act->document_path) {
                if (str_starts_with($act->document_path, '["')) {
                    $docPaths = json_decode($act->document_path, true) ?? [];
                    $docNames = $act->file_name ? explode(', ', $act->file_name) : [];
                }
                else {
                    $docPaths = [$act->document_path];
                    $docNames = [$act->file_name ?? ''];
                }
            }

            if ($typeName === 'Exposure') {
                $exposureData[] = [
                    'id' => $act->id,
                    'mentor' => $act->verifier ? $act->verifier->nama : '-',
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'lokasi' => $act->location,
                    'aktivitas' => $act->activity,
                    'deskripsi' => $act->description,
                    'file_paths' => $docPaths,
                    'file_names' => $docNames,
                    'status' => $act->status,
                ];
            }
            elseif ($typeName === 'Mentoring') {
                $mentoringData[] = [
                    'id' => $act->id,
                    'mentor' => $act->verifier ? $act->verifier->nama : '-',
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'lokasi' => $act->location,
                    'deskripsi' => $act->description,
                    'action_plan' => $act->action_plan,
                    'file_paths' => $docPaths,
                    'file_names' => $docNames,
                    'status' => $act->status,
                ];
            }
            elseif ($typeName === 'Learning') {
                $learningData[] = [
                    'id' => $act->id,
                    'sumber' => $act->activity,
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'platform' => $act->platform,
                    'file_paths' => $docPaths,
                    'file_names' => $docNames,
                    'status' => $act->status,
                ];
            }
        }

        return view('talent.logbook', compact(
            'user',
            'notifications',
            'exposureData',
            'mentoringData',
            'learningData'
        ));
    }



    public function logbookItemDetail($id)
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan']);
        $notifications = $this->getNotifications();

        $activity = \App\Models\IdpActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);

        if ($activity->user_id_talent !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('talent.logbook-detail', compact('user', 'activity', 'notifications'));
    }

    public function editIdpMonitoring($id)
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan', 'promotion_plan']);
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses halaman ini.');
            }

            $activity = IdpActivity::with('type', 'verifier')->findOrFail($id);
            if ($activity->user_id_talent !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $tab = strtolower($activity->type->type_name ?? 'exposure');

            // Ambil mentor dari promotion plan (multiple mentors)
            $mentors = $user->promotion_plan ? $user->promotion_plan->mentor_models : collect();
            $atasans = $user->atasan ? collect([$user->atasan]) : collect();

            $notifications = $this->getNotifications();
            $editMode = true;

            return view('talent.idp-monitoring', compact('user', 'tab', 'mentors', 'atasans', 'notifications', 'activity', 'editMode'));
        }
        catch (\Exception $e) {
            Log::error('talentDashboard editIdpMonitoring error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit logbook.');
        }
    }

    public function updateIdpMonitoring(Request $request, $id)
    {
        try {
            $user = Auth::user();

            if (optional($user->promotion_plan)->is_locked) {
                return back()->with('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            }

            $activity = IdpActivity::with('type')->findOrFail($id);

            if ($activity->user_id_talent !== $user->id) {
                abort(403, 'Unauthorized action.');
            }

            $tab = strtolower($activity->type->type_name ?? 'exposure');

            // ── Validasi input ──────────────────────────────────────────────
            $rules = [
                'theme' => 'required|string|max:255',
                'activity_date' => 'required|date',
                'documents' => 'nullable|array|max:5', // maks 5 file
                'documents.*' => 'file|max:5120|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx',
            ];

            if ($tab === 'learning') {
                $rules['activity'] = 'required|string|max:255';
                $rules['platform'] = 'required|string|max:255';
            }
            else {
                $rules['mentor_name'] = 'required|string|max:255';
                $rules['location'] = 'required|string|max:255';
            }

            if ($tab === 'mentoring') {
                $rules['description'] = 'required|string';
                $rules['action_plan'] = 'required|string';
            }
            elseif ($tab === 'exposure') {
                $rules['activity'] = 'required|string';
                $rules['description'] = 'required|string';
            }

            // Merge activity and description based on tab
            $tab_from_request = $request->input('tab_type', $tab);
            if ($tab_from_request === 'learning') {
                $request->merge(['activity' => $request->input('activity_learning')]);
            }
            elseif ($tab_from_request === 'exposure') {
                $request->merge([
                    'activity' => $request->input('activity_exposure'),
                    'description' => $request->input('description_exposure')
                ]);
            }
            elseif ($tab_from_request === 'mentoring') {
                $request->merge(['description' => $request->input('description_mentoring')]);
            }

            $validated = $request->validate($rules, [
                'documents.max' => 'Maksimal 5 file yang bisa diupload.',
                'documents.*.max' => 'Ukuran setiap file tidak boleh melebihi 5 MB.',
                'documents.*.mimes' => 'Format file harus: PNG, JPG, PDF, DOC, DOCX, XLS, XLSX.',
            ]);

            // ── Upload file(s) / Hapus file yang dihapus user ────────────────
            $keptPaths = $request->input('existing_documents_paths', []);
            $keptNames = $request->input('existing_documents_names', []);

            // Evaluasi file lama mana yang dihapus user dari UI
            if ($activity->document_path) {
                $oldPaths = [];
                if (str_starts_with($activity->document_path, '["')) {
                    $oldPaths = json_decode($activity->document_path, true);
                }
                else {
                    $oldPaths = [$activity->document_path];
                }

                $deletedPaths = array_diff($oldPaths, $keptPaths);
                foreach ($deletedPaths as $path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                }
            }

            // Re-index array setelah array_diff dll
            $keptPaths = array_values($keptPaths);
            $keptNames = array_values($keptNames);

            // Tambahkan file-file yang baru diunggah
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $keptNames[] = $file->getClientOriginalName();
                    $keptPaths[] = $file->store('idp_documents', 'public');
                }
            }

            // Gabungkan menjadi format string/JSON akhir
            $documentPath = count($keptPaths) === 1
                ? $keptPaths[0]
                : (count($keptPaths) > 1 ? json_encode($keptPaths) : '');

            $fileName = count($keptNames) === 1
                ? $keptNames[0]
                : (count($keptNames) > 1 ? implode(', ', $keptNames) : null);

            // ── Verify by (mentor) ──────────────────────────────────────────
            $verifyById = $activity->verify_by;
            if ($request->filled('mentor_name')) {
                $verifyById = User::where('nama', $request->mentor_name)->value('id');
            }

            // ── Update ke DB ────────────────────────────────────────────────
            $activity->update([
                'verify_by' => $verifyById,
                'theme' => $validated['theme'],
                'activity_date' => $validated['activity_date'],
                'location' => $request->location ?? $activity->location,
                'activity' => $request->activity ?? $activity->activity,
                'description' => $request->description ?? $activity->description,
                'action_plan' => $request->action_plan ?? $activity->action_plan,
                'document_path' => $documentPath,
                'file_name' => $fileName,
                'platform' => $request->platform ?? $activity->platform,
                'status' => 'Pending', // Kembalikan ke Pending bila diedit
            ]);

            return redirect()->route('talent.logbook.detail')->with('success', 'IDP Activity berhasil diperbarui.');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
        catch (\Exception $e) {
            Log::error('talentDashboard updateIdpMonitoring error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function destroyIdpMonitoring($id)
    {
        try {
            $user = Auth::user();
            if (optional($user->promotion_plan)->is_locked) {
                return back()->with('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            }

            $act = IdpActivity::findOrFail($id);
            if ($act->user_id_talent !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            // Optionally delete old file path from storage
            if ($act->document_path) {
                if (str_starts_with($act->document_path, '["')) {
                    $paths = json_decode($act->document_path, true);
                    foreach ($paths as $path) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                    }
                }
                else {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($act->document_path);
                }
            }

            $act->delete();
            return redirect()->back()->with('success', 'Data logbook berhasil dihapus.');
        }
        catch (\Exception $e) {
            Log::error('talentDashboard destroyIdpMonitoring error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data logbook.');
        }
    }

    public function riwayat()
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan']);
            if ($user->role->role_name !== 'talent') {
                abort(403);
            }

            $notifications = $this->getNotifications();

            // Ambil semua sesi assessment (IDP cycles) milik talent ini
            $sessions = DB::table('assessment_session')
                ->where('user_id_talent', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('talent.riwayat', compact('user', 'notifications', 'sessions'));
        }
        catch (\Exception $e) {
            Log::error('talent riwayat error: ' . $e->getMessage());
            throw $e;
        }
    }
    public function riwayatDetail($id)
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan', 'promotion_plan.targetPosition']);
            if ($user->role->role_name !== 'talent') {
                abort(403);
            }

            $notifications = $this->getNotifications();

            // Sesi Assessment yang dipilih
            $session = DB::table('assessment_session')
                ->where('id', $id)
                ->where('user_id_talent', $user->id)
                ->first();

            if (!$session) {
                abort(404, 'Data riwayat tidak ditemukan.');
            }

            // Data Kompetensi dari sesi ini
            $details = DB::table('detail_assessment')
                ->join('competencies', 'detail_assessment.competence_id', '=', 'competencies.id')
                ->where('assessment_id', $session->id)
                ->select('competencies.name', 'detail_assessment.score_talent', 'detail_assessment.score_atasan', 'detail_assessment.gap_score')
                ->get();

            $kompetensiData = [];
            foreach ($details as $d) {
                $avg = min(5, ($d->score_talent + $d->score_atasan) / 2);
                $kompetensiData[$d->name] = [
                    'score' => $avg,
                    'gap' => $d->gap_score ?? 0
                ];
            }

            // IDP Monitoring (Aktivitas)
            $idpActivities = IdpActivity::with('type')
                ->where('user_id_talent', $user->id)
                ->get();

            $exposureCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Exposure')->count();
            $learningCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Learning')->count();
            $mentoringCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Mentoring')->count();

            // Project Improvement
            $projects = ImprovementProject::where('user_id_talent', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('talent.riwayat-detail', compact(
                'user',
                'notifications',
                'session',
                'kompetensiData',
                'exposureCount',
                'learningCount',
                'mentoringCount',
                'projects'
            ));
        }
        catch (\Exception $e) {
            Log::error('talent riwayatDetail error: ' . $e->getMessage());
            throw $e;
        }
    }
}
