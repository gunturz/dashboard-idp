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

            return view('talent.dashboard', compact('user', 'kompetensi', 'notifications', 'competenciesList', 'projects'));
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
                    'competence_id' => (int) $competenceId,
                    'score_atasan'  => 0, // diisi nanti oleh Atasan
                    'score_talent'  => (int) $scoreTalent,
                    'gap_score'     => 0, // diisi nanti/bisa update
                    'notes'         => 'Completed by talent',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            // 3. Batch Insert ke tabel detail_assessment
            DB::table('detail_assessment')->insert($details);

            DB::commit();

            return redirect()->route('talent.dashboard')->with('success', 'Berhasil! Penilaian kompetensi Anda telah tersimpan ke sistem.');
            
        } catch (\Exception $e) {
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
            $mentors = User::whereHas('role', function($q) {
                $q->where('role_name', 'mentor');
            })->get();

            $atasans = User::whereHas('role', function($q) {
                $q->where('role_name', 'atasan');
            })->get();
            
            $notifications = $this->getNotifications();
            
            return view('talent.idp-monitoring', compact('user', 'tab', 'mentors', 'atasans', 'notifications'));
        } catch (\Exception $e) {
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
                'theme'         => 'required|string|max:255',
                'activity_date' => 'required|date',
                'documents'     => 'nullable|array|max:5',          // maks 5 file
                'documents.*'   => 'file|max:5120|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx',
            ];

            if ($tab === 'learning') {
                $rules['activity'] = 'required|string|max:255';
                $rules['platform'] = 'required|string|max:255';
            } else {
                $rules['mentor_name'] = 'required|string|max:255';
                $rules['location']    = 'required|string|max:255';
            }

            if ($tab === 'mentoring') {
                $rules['description'] = 'required|string';
                $rules['action_plan'] = 'required|string';
            } elseif ($tab === 'exposure') {
                $rules['activity']    = 'required|string';
                $rules['description'] = 'required|string';
            }

            $validated = $request->validate($rules, [
                'documents.max'    => 'Maksimal 5 file yang bisa diupload.',
                'documents.*.max'  => 'Ukuran setiap file tidak boleh melebihi 5 MB.',
                'documents.*.mimes'=> 'Format file harus: PNG, JPG, PDF, DOC, DOCX, XLS, XLSX.',
            ]);

            // ── Type IDP ────────────────────────────────────────────────────
            $typeId = DB::table('idp_type')->where('type_name', ucfirst($tab))->value('id');
            if (!$typeId) {
                return back()->with('error', 'Tipe IDP tidak valid.');
            }

            // ── Upload file(s) ──────────────────────────────────────────────
            $documentPaths = [];
            $fileNames     = [];

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $fileNames[]     = $file->getClientOriginalName();
                    $documentPaths[] = $file->store('idp_documents', 'public');
                }
            }

            $documentPath = count($documentPaths) === 1
                ? $documentPaths[0]                    // satu file → simpan string biasa
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
                'type_idp'       => $typeId,
                'verify_by'      => $verifyById,
                'theme'          => $validated['theme'],
                'activity_date'  => $validated['activity_date'],
                'location'       => $request->location ?? '',
                'activity'       => $request->activity ?? '',
                'description'    => $request->description ?? '',
                'action_plan'    => $request->action_plan ?? '',
                'document_path'  => $documentPath,
                'file_name'      => $fileName,
                'status'         => 'Pending',
                'platform'       => $request->platform ?? '',
            ]);

            return redirect()->route('talent.dashboard')->with('success', 'IDP Activity berhasil disubmit.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('talentDashboard storeIdpMonitoring error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function storeProject(Request $request)
    {
        try {
            $request->validate([
                'title'        => 'required|string|max:255',
                'project_file' => 'required|file|max:10240|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
            ], [
                'title.required'        => 'Judul project harus diisi.',
                'project_file.required' => 'File project harus diunggah.',
                'project_file.max'      => 'Ukuran file tidak boleh melebihi 10 MB.',
                'project_file.mimes'    => 'Format file tidak didukung.',
            ]);

            $documentPath = $request->file('project_file')
                ->store('improvement_projects', 'public');

            ImprovementProject::create([
                'user_id_talent' => Auth::id(),
                'title'          => $request->title,
                'document_path'  => $documentPath,
                'status'         => 'Pending',
            ]);

            return redirect()->route('talent.dashboard')
                ->with('success_project', 'Project Improvement berhasil disubmit.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
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

        // Data dummy – ganti dengan query DB saat tabel logbook sudah tersedia
        $exposureData  = [];
        $mentoringData = [];
        $learningData  = [];

        return view('talent.logbook-detail', compact(
            'user', 'notifications', 'exposureData', 'mentoringData', 'learningData'
        ));
    }

    private function getNotifications() {
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
}
