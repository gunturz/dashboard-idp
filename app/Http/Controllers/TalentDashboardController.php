<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\IdpActivity;
use App\Models\User;

class TalentDashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user()->load(['company', 'department', 'position', 'role', 'promotion_plan.targetPosition']);
            
            if ($user->role->role_name !== 'talent' && $user->role->role_name !== 'talent') {
                abort(403, 'Hanya talent/talent yang bisa mengakses dashboard ini.');
            }
            
            $kompetensi = null;
            $notifications = $this->getNotifications();
            $competenciesList = DB::table('competencies')->pluck('name')->toArray();

            return view('talent.dashboard', compact('user', 'kompetensi', 'notifications', 'competenciesList'));
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
            $user = Auth::user();
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
            
            return view('talent.idp-monitoring', compact('user', 'tab', 'mentors', 'atasans'));
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

            $typeId = DB::table('idp_type')->where('type_name', ucfirst($tab))->value('id');
            if (!$typeId) {
                return back()->with('error', 'Tipe IDP tidak valid.');
            }

            $documentPath = '';
            $fileName = null;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $fileName = $file->getClientOriginalName();
                $documentPath = $file->store('idp_documents', 'public');
            }

            $verifyById = null;
            if ($request->filled('mentor_name')) {
                $verifyById = User::where('nama', $request->mentor_name)->value('id');
            }

            IdpActivity::create([
                'user_id_talent' => $user->id,
                'type_idp' => $typeId,
                'verify_by' => $verifyById,
                'theme' => $request->theme ?? '',
                'activity_date' => $request->activity_date,
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
        } catch (\Exception $e) {
            Log::error('talentDashboard storeIdpMonitoring error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function notifikasi()
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        return view('talent.notifikasi', compact('user', 'notifications'));
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
