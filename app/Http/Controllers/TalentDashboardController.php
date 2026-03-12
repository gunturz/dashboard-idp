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

            $kompetensi = null;
            $notifications = $this->getNotifications();
            $competenciesList = DB::table('competencies')->pluck('name')->toArray();

            // Project Improvement: ambil data milik user ini
            $projects = ImprovementProject::where('user_id_talent', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();


            //  return view('talent.dashboard', compact('user', 'kompetensi', 'notifications', 'competenciesList', 'projects'));

            $idpActivities = IdpActivity::with('type')
                ->where('user_id_talent', $user->id)
                ->get();

            $exposureCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Exposure')->count();
            $learningCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Learning')->count();
            $mentoringCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Mentoring')->count();

            return view('talent.dashboard', compact('user', 'kompetensi', 'notifications', 'competenciesList', 'projects', 'exposureCount', 'learningCount', 'mentoringCount'));
        }
        catch (\Exception $e) {
            Log::error('talentDashboard error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function competency()
    {
        try {
            $user = Auth::user();
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent yang bisa mengakses halaman ini.');
            }

            return view('talent.competency', compact('user'));
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

            // Validasi Input Array Score dari request POST
            $data = $request->validate([
                'scores' => 'required|array',
                'scores.*' => 'required|integer|min:1|max:5',
            ]);

            DB::beginTransaction();

            $bulanTahun = now()->format('F Y');

            // 1. Buat Header / Sesi Assessment Baru
            $assessmentId = DB::table('assessment_session')->insertGetId([
                'user_id_talent' => $user->id,
                // Assign supervisor ID defaults if null for assessment
                'user_id_atasan' => $user->atasan_id ?? $user->id,
                'period' => "Assessment {$bulanTahun}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Siapkan Data Multiple Detail Assessment untuk di-insert
            $details = [];
            foreach ($data['scores'] as $competenceId => $scoreTalent) {
                // Konversi competenceId jika ada validasi dari string dict/array index
                $details[] = [
                    'assessment_id' => $assessmentId,
                    'competence_id' => (int)$competenceId,
                    'score_atasan' => 0, // diisi nanti oleh Atasan
                    'score_talent' => (int)$scoreTalent,
                    'gap_score' => 0, // diisi nanti/bisa update
                    'notes' => 'Completed by talent',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 3. Batch Insert ke tabel detail_assessment
            DB::table('detail_assessment')->insert($details);

            DB::commit();

            return redirect()->route('talent.dashboard')->with('success', 'Berhasil! Penilaian kompetensi Anda telah tersimpan ke sistem.');

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
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan']);
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses halaman ini.');
            }

            // Get mentors and atasans for the dropdown list using relations
            $mentors = User::whereHas('role', function ($q) {
                $q->where('role_name', 'mentor');
            })->get();

            $atasans = User::whereHas('role', function ($q) {
                $q->where('role_name', 'atasan');
            })->get();

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

            $validated = $request->validate($rules, [
                'documents.max' => 'Maksimal 5 file yang bisa diupload.',
                'documents.*.max' => 'Ukuran setiap file tidak boleh melebihi 5 MB.',
                'documents.*.mimes' => 'Format file harus: PNG, JPG, PDF, DOC, DOCX, XLS, XLSX.',
            ]);

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

            return redirect()->route('talent.dashboard')->with('success', 'IDP Activity berhasil disubmit.');

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

    public function notifikasi()
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        return view('talent.notifikasi', compact('user', 'notifications'));
    }

    public function markAllNotificationsRead(Request $request)
    {
        // Tandai semua notifikasi sebagai sudah dibaca
        // Jika ada tabel notifications di DB, update di sini.
        // Contoh: DB::table('notifications')->where('user_id', Auth::id())->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    public function logbookDetail()
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan']);
        $notifications = $this->getNotifications();

        $activities = \App\Models\IdpActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $user->id)
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
                    'tanggal' => $act->activity_date,
                    'platform' => $act->platform,
                    'file_paths' => $docPaths,
                    'file_names' => $docNames,
                    'status' => $act->status,
                ];
            }
        }

        return view('talent.logbook-detail', compact(
            'user', 'notifications', 'exposureData', 'mentoringData', 'learningData'
        ));
    }

    private function getNotifications()
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Submit IDP Berhasil',
                'desc' => 'Formulir <span class="font-semibold">Exposure</span> Anda telah berhasil dikirim dan sedang menunggu tinjauan dari mentor/atasan.',
                'type' => 'success', // success, info, warning
                'time' => '10 menit yang lalu',
                'is_read' => false,
                'badge' => 'Baru'
            ]
        ]);
    }

    public function editIdpMonitoring($id)
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'mentor', 'atasan']);
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses halaman ini.');
            }

            $activity = IdpActivity::with('type', 'verifier')->findOrFail($id);
            if ($activity->user_id_talent !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $tab = strtolower($activity->type->type_name ?? 'exposure');

            // Get mentors and atasans for the dropdown list using relations
            $mentors = User::whereHas('role', function ($q) {
                $q->where('role_name', 'mentor');
            })->get();

            $atasans = User::whereHas('role', function ($q) {
                $q->where('role_name', 'atasan');
            })->get();

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
}
