<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\PromotionPlan;
use App\Models\ImprovementProject;
use App\Models\PanelisAssessment;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\IdpActivity;
use Illuminate\Http\Request;

class PanelisController extends Controller
{


    /**
     * Panelis Dashboard — shows all talents grouped by company with target position, talent, department, mentor, atasan.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // IDs talent yang sudah dinilai SELESAI oleh panelis yang sedang login
        $alreadyAssessedTalentIds = PanelisAssessment::where('panelis_id', $user->id)
            ->whereNotNull('panelis_score')
            ->pluck('user_id_talent')
            ->toArray();

        // Fetch talents with status Pending Panelis yang di-assign ke panelis ini
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->whereHas('promotion_plan', function ($q) {
            $q->where('status_promotion', 'Pending Panelis')
                ->whereNotNull('target_position_id');
        })
            ->whereNotIn('id', $alreadyAssessedTalentIds)
            // Hanya talent khusus untuk panelis ini (assignment)
            ->whereHas('panelisAssessments', function ($q) use ($user) {
                $q->where('panelis_id', $user->id);
            })
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->get();

        // Group by company -> target position -> talents
        $groupedData = $talents->groupBy('company_id')->map(function ($companyTalents) {
            return [
            'company' => $companyTalents->first()->company,
            'positions' => $companyTalents->groupBy(function ($item) {
                    return $item->promotion_plan->target_position_id ?? 0;
                }
                )->map(function ($positionTalents) {
                    return [
                    'targetPosition' => $positionTalents->first()->promotion_plan->targetPosition ?? null,
                    'talents' => $positionTalents,
                    ];
                }
                ),
                ];
            });

        return view('panelis.dashboard', compact('user', 'groupedData'))
            ->with('notifications', $this->getNotifications());
    }

    /**
     * Panelis Review — shows improvement projects pending Panelis review (assessment-based review).
     */
    public function review()
    {
        $user = auth()->user();

        // Get talents with improvement projects that have been scored/assessed
        $projects = ImprovementProject::with([
            'talent.position',
            'talent.department',
            'talent.company',
            'talent.promotion_plan.targetPosition',
            'talent.assessmentSession.details.competence',
        ])
            ->whereNotNull('feedback')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        return view('panelis.review', compact('user', 'projects'))
            ->with('notifications', $this->getNotifications());
    }

    /**
     * Panelis Talent Detail — full detail view for a single talent (Image 1).
     */
    public function detailTalent($talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
            'assessmentSession.details.competence',
            'idpActivities.type',
            'improvementProjects',
        ])->findOrFail($talent_id);

        $competencies = Competence::all();
        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ?PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        // IDP donut counts
        $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
        $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
        $learningCount = $talent->idpActivities->where('type_idp', 3)->count();

        // TOP 3 GAP
        $details = optional($talent->assessmentSession)->details;
        $gaps = collect();
        if ($details) {
            $overrides = $details->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))
                ->sortBy(fn($d) => (int)explode('|', str_replace('priority_', '', $d->notes))[0]);
            $gaps = $overrides->count() > 0 ? $overrides->values() : $details->sortBy('gap_score')->take(3)->values();
        }

        return view('panelis.detail', compact(
            'user', 'talent', 'competencies', 'standards', 'gaps',
            'exposureCount', 'mentoringCount', 'learningCount'
        ))->with('notifications', $this->getNotifications());
    }

    /**
     * Panelis Logbook Detail — logbook tabs page for a single talent (Images 2-4).
     */
    public function logbook($talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'idpActivities.verifier',
            'position',
            'department',
        ])->findOrFail($talent_id);

        $exposureActivities = $talent->idpActivities->where('type_idp', 1);
        $mentoringActivities = $talent->idpActivities->where('type_idp', 2);
        $learningActivities = $talent->idpActivities->where('type_idp', 3);

        return view('panelis.logbook', compact(
            'user', 'talent',
            'exposureActivities', 'mentoringActivities', 'learningActivities'
        ))->with('notifications', $this->getNotifications());
    }

    /**
     * Panelis Penilaian — assessment form for a single talent.
     */
    public function penilaian($talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
            'improvementProjects',
        ])->findOrFail($talent_id);

        // Get the latest improvement project (if any) for file preview
        $project = $talent->improvementProjects->last();

        // Cek apakah panelis ini sudah pernah menilai talent ini
        $existingAssessment = PanelisAssessment::where('user_id_talent', $talent_id)
            ->where('panelis_id', $user->id)
            ->first();

        return view('panelis.penilaian', compact('user', 'talent', 'project', 'existingAssessment'))
            ->with('notifications', $this->getNotifications());
    }

    /**
     * Panelis Simpan Penilaian — store Panelis assessment scores to database.
     */
    public function simpanPenilaian(\Illuminate\Http\Request $request, $talent_id)
    {
        $user = auth()->user();

        $scores = $request->input('scores', []); // array of integers
        $totalScore = array_sum($scores);

        // Simpan / update penilaian panelis ini untuk talent ini (per panelis per talent)
        PanelisAssessment::updateOrCreate(
        [
            'user_id_talent' => $talent_id,
            'panelis_id' => $user->id,
        ],
        [
            'panelis_score' => $totalScore,
            'panelis_scores_json' => $scores,
            'panelis_komentar' => $request->input('komentar'),
            'panelis_rekomendasi' => $request->input('rekomendasi'),
            'panelis_tanggal_penilaian' => $request->input('tanggal_penilaian', now()->toDateString()),
        ]
        );

        return redirect()->route('panelis.history')
            ->with('success', 'Penilaian berhasil disimpan! Total skor: ' . $totalScore);
    }

    /**
     * Panelis History — shows completed/reviewed assessments by Panelis.
     */
    public function history()
    {
        $user = auth()->user();

        // Tampilkan hanya penilaian yang dibuat oleh panelis ini
        $assessments = PanelisAssessment::where('panelis_id', $user->id)
            ->with([
            'talent.position',
            'talent.department',
            'talent.company',
            'talent.promotion_plan.targetPosition',
            'talent.improvementProjects',
        ])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('panelis.history', compact('user', 'assessments'))
            ->with('notifications', $this->getNotifications());
    }

    /**
     * Panelis Notifikasi — full notification page.
     */
    public function notifikasi()
    {
        $user = auth()->user();
        $notifications = $this->getNotifications();

        return view('panelis.notifikasi', compact('user', 'notifications'));
    }

    /**
     * Panelis Profile — personal profile page for the logged-in Panelis user.
     */
    public function profile()
    {
        $user = auth()->user()->load('company');
        return view('panelis.profile', compact('user'))
            ->with('notifications', $this->getNotifications());
    }

    public function logbookItemDetail($id)
    {
        $user = auth()->user();
        $activity = \App\Models\IdpActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);
        return view('bod.logbook-item', compact('user', 'activity'))
               ->with('notifications', $this->getNotifications());
    }


}
