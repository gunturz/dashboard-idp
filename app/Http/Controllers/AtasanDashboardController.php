<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\IdpType;

class AtasanDashboardController extends Controller
{
    protected function applyActiveTalentScope($query, int $atasanId)
    {
        return $query->where('atasan_id', $atasanId)
            ->whereHas('promotion_plan', function ($q) {
                $q->where('is_active', true);
            });
    }

    public function notifikasi()
    {
        return view('atasan.notifikasi', [
            'user' => Auth::user(),
            'notifications' => $this->getNotifications()
        ]);
    }



    public function dashboard()
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);

        // Fetch ALL subordinates for summary stats
        $allTalents = $this->applyActiveTalentScope(User::query(), $user->id)
            ->with([
                'position',
                'department',
                'promotion_plan.targetPosition',
                'assessmentSession.details.competence',
            ])
            ->get();

        // Summary stats
        $totalTalents = $allTalents->count();

        // Assessment Pending = talents where atasan has NOT scored yet (score_atasan is all 0)
        $assessmentPending = 0;
        $onTrack = 0;

        foreach ($allTalents as $talent) {
            $session = $talent->assessmentSession;
            if (!$session || !$session->details || $session->details->isEmpty()) {
                continue;
            }

            $totalAtasanScore = $session->details->sum('score_atasan');
            if ($totalAtasanScore == 0) {
                $assessmentPending++;
            } else {
                $onTrack++;
            }
        }

        // Only show talents that have NOT been assessed by atasan yet
        $talents = $allTalents->filter(function ($talent) {
            $session = $talent->assessmentSession;
            if (!$session || !$session->details || $session->details->isEmpty()) {
                return false; // Belum ada sesi assessment — jangan tampilkan
            }
            $totalAtasanScore = $session->details->sum('score_atasan');
            return $totalAtasanScore == 0; // Hanya tampilkan yang belum dinilai
        })->values();

        // Competencies and standards
        $competencies = Competence::orderBy('id')->get();

        // Build standards lookup: for each talent, get their target position standards
        $allStandards = [];
        foreach ($allTalents as $talent) {
            $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
            if ($positionId && !isset($allStandards[$positionId])) {
                $allStandards[$positionId] = PositionTargetCompetence::where('position_id', $positionId)
                    ->pluck('target_level', 'competence_id');
            }
        }

        return view('atasan.dashboard', compact(
            'user',
            'talents',
            'totalTalents',
            'assessmentPending',
            'onTrack',
            'competencies',
            'allStandards'
        ));
    }

    public function monitoring()
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);

        $talents = $this->applyActiveTalentScope(User::query(), $user->id)
            ->with([
                'department',
                'position',
                'mentor',
                'atasan',
                'company',
                'promotion_plan.targetPosition',
                'assessmentSession.details.competence',
                'idpActivities.type',
                'idpActivities.verifier',
                'improvementProjects.verifier',
            ])
            ->get();

        $competencies = Competence::all();

        // Collect all target position IDs and fetch their standards
        $positionIds = $talents->map(fn($t) => optional($t->promotion_plan)->target_position_id)->filter()->unique();
        $standards = collect();
        if ($positionIds->isNotEmpty()) {
            // Use the first talent's target position standards (they share the same target typically)
            $posId = $positionIds->first();
            $standards = PositionTargetCompetence::where('position_id', $posId)
                ->pluck('target_level', 'competence_id');
        }

        return view('atasan.monitoring_atasan', compact('user', 'talents', 'competencies', 'standards'));
    }

    public function assessmentPage($talentId)
    {
        $user = Auth::user();
        $talent = User::where('atasan_id', $user->id)
            ->with(['promotion_plan.targetPosition', 'position'])
            ->findOrFail($talentId);

        // Find the ACTIVE assessment session for this talent
        $session = DB::table('assessment_session')
            ->where('user_id_talent', $talentId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$session) {
            return redirect()->route('atasan.dashboard')->with('error', 'Assessment session belum dibuat oleh talent.');
        }

        $competencies = Competence::with([
            'questions' => function ($q) {
                $q->orderBy('level');
            }
        ])->get();

        $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
        $targetLevels = $positionId
            ? PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        return view('atasan.competency_atasan', compact('user', 'talent', 'competencies', 'targetLevels'));
    }

    public function storeAssessment(Request $request, $talentId)
    {
        $user = Auth::user();

        // Validate scores
        $data = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:0|max:5',
        ]);

        // Find the ACTIVE assessment session for this talent
        // Filter by is_active = true ensures we don't accidentally update an archived session
        $session = DB::table('assessment_session')
            ->where('user_id_talent', $talentId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$session) {
            return back()->with('error', 'Assessment session tidak ditemukan.');
        }

        // Get the talent's target position for standards
        $talent = User::with('promotion_plan')->find($talentId);
        $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
        $standards = PositionTargetCompetence::where('position_id', $positionId)
            ->pluck('target_level', 'competence_id');

        // Update each detail_assessment row with atasan score and recalculate gap
        foreach ($data['scores'] as $competenceId => $scoreAtasan) {
            $detail = DB::table('detail_assessment')
                ->where('assessment_id', $session->id)
                ->where('competence_id', $competenceId)
                ->first();

            if ($detail) {
                $scoreTalent = $detail->score_talent;
                $finalScore = ($scoreTalent + $scoreAtasan) / 2;
                $standard = $standards[$competenceId] ?? 0;
                $gapScore = $finalScore - $standard;

                DB::table('detail_assessment')
                    ->where('id', $detail->id)
                    ->update([
                        'score_atasan' => $scoreAtasan,
                        'gap_score' => $gapScore,
                        'updated_at' => now(),
                    ]);
            }
        }

        $this->addNotificationToUser(
            $talentId,
            'Penilaian Kompetensi dari Atasan Sudah Tersedia',
            'Atasan Anda, <span class="font-semibold">' . e($user->nama) . '</span>, telah memberikan penilaian kompetensi untuk assessment terbaru Anda.',
            'info'
        );

        $this->notifyPdcAdmins(
            'Penilaian Atasan Selesai',
            'Atasan <span class="font-semibold">' . e($user->nama) . '</span> telah memberikan penilaian kompetensi untuk talent <span class="font-semibold">' . e(optional($talent)->nama ?? 'Talent') . '</span>.',
            'info'
        );

        return redirect()->route('atasan.monitoring')->with('open_bell_notif', true);
    }

    public function logbookItemDetail($id)
    {
        $user = Auth::user();
        $activity = \App\Models\IdpActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);
        return view('atasan.logbook-item', compact('user', 'activity'));
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);
        $finalStatuses = ['Approved Panelis', 'Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'];
        $search = $request->input('search');
        $filterPeriode = $request->input('periode');
        $filterPerusahaan = $request->input('perusahaan');
        $filterDepartemen = $request->input('departemen');

        $talentsQuery = User::whereHas('all_promotion_plans', function ($q) use ($user, $finalStatuses) {
                $q->where('is_active', false)
                    ->whereIn('status_promotion', $finalStatuses)
                    ->whereHas('developmentSession', function ($sessionQuery) use ($user) {
                        $sessionQuery->where('atasan_id', $user->id);
                    });
            })
            ->with([
                'position',
                'department',
                'company',
                'all_promotion_plans' => function ($q) use ($user, $finalStatuses) {
                    $q->where('is_active', false)
                        ->whereIn('status_promotion', $finalStatuses)
                        ->whereHas('developmentSession', function ($sessionQuery) use ($user) {
                            $sessionQuery->where('atasan_id', $user->id);
                        })
                        ->with('targetPosition')
                        ->with('developmentSession.sourcePosition')
                        ->orderByDesc('created_at');
                },
                'all_assessmentSessions.details.competence',
                'all_improvementProjects'
            ]);

        if ($search) {
            $talentsQuery->where('nama', 'like', '%' . $search . '%');
        }

        $talentModels = $talentsQuery->get();
        $talents = collect();

        foreach ($talentModels as $talent) {
            foreach ($talent->all_promotion_plans as $archivedPlan) {
                if ($archivedPlan->is_active || !in_array($archivedPlan->status_promotion, $finalStatuses, true)) {
                    continue;
                }

                $sessionId = $archivedPlan->development_session_id;
                $historyRow = $talent->replicate();
                $historyRow->id = $talent->id;
                $historyRow->exists = true;
                $historyRow->setRelations($talent->getRelations());
                $historyRow->promotion_plan = $archivedPlan;
                $historyRow->archive_session_id = $sessionId;

                if ($archivedPlan->developmentSession?->sourcePosition) {
                    $historyRow->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
                }

                $historyRow->assessmentSession = $sessionId
                    ? $talent->all_assessmentSessions->firstWhere('development_session_id', $sessionId)
                    : $talent->all_assessmentSessions->first();
                $historyRow->improvementProjects = $sessionId
                    ? $talent->all_improvementProjects->where('development_session_id', $sessionId)->values()
                    : $talent->all_improvementProjects;

                $talents->push($historyRow);
            }
        }

        $talents = $talents
            ->sortByDesc(function ($talent) {
                return optional(optional($talent->promotion_plan)->developmentSession)->completed_at
                    ?? optional($talent->promotion_plan)->updated_at
                    ?? optional($talent->promotion_plan)->created_at;
            })
            ->values();

        $competencies = Competence::orderBy('id')->get();

        // Build filter options
        $periodeOptions = $talents
            ->filter(fn($t) => $t->promotion_plan && $t->promotion_plan->start_date && $t->promotion_plan->target_date)
            ->map(fn($t) => $t->promotion_plan->start_date->format('Y') . '/' . $t->promotion_plan->target_date->format('Y'))
            ->unique()->values();

        $perusahaanOptions = $talents->map(fn($t) => $t->company?->nama_company ?? null)->filter()->unique()->values();
        $departemenOptions = $talents->map(fn($t) => $t->department?->nama_department ?? null)->filter()->unique()->values();

        // Apply filters in PHP
        if ($filterPeriode) {
            $talents = $talents->filter(function ($t) use ($filterPeriode) {
                if (!$t->promotion_plan || !$t->promotion_plan->start_date || !$t->promotion_plan->target_date)
                    return false;
                $key = $t->promotion_plan->start_date->format('Y') . '/' . $t->promotion_plan->target_date->format('Y');
                return $key === $filterPeriode;
            })->values();
        }
        if ($filterPerusahaan) {
            $talents = $talents->filter(fn($t) => ($t->company?->nama_company ?? '') === $filterPerusahaan)->values();
        }
        if ($filterDepartemen) {
            $talents = $talents->filter(fn($t) => ($t->department?->nama_department ?? '') === $filterDepartemen)->values();
        }

        return view('atasan.riwayat', compact(
            'user',
            'talents',
            'competencies',
            'search',
            'filterPeriode',
            'filterPerusahaan',
            'filterDepartemen',
            'periodeOptions',
            'perusahaanOptions',
            'departemenOptions'
        ));
    }

    public function monitoringDetail($talentId)
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);
        $talent = User::where('atasan_id', $user->id)
            ->with([
                'position',
                'department',
                'company',
                'mentor',
                'atasan',
                'promotion_plan.targetPosition',
                'assessmentSession.details.competence',
                'idpActivities.type',
                'improvementProjects',
                'all_promotion_plans.targetPosition',
                'all_promotion_plans.developmentSession.sourcePosition',
                'all_assessmentSessions.details.competence',
                'all_idpActivities.type',
                'all_improvementProjects'
            ])
            ->findOrFail($talentId);

        if (!$talent->promotion_plan && $talent->all_promotion_plans->isNotEmpty()) {
            $talent->promotion_plan = $talent->all_promotion_plans->firstWhere('is_active', false) ?? $talent->all_promotion_plans->first();
        }

        if (!$talent->assessmentSession && $talent->all_assessmentSessions->isNotEmpty()) {
            $talent->assessmentSession = $talent->all_assessmentSessions->firstWhere('is_active', false) ?? $talent->all_assessmentSessions->first();
        }

        if ($talent->idpActivities->isEmpty() && $talent->all_idpActivities->isNotEmpty()) {
            $talent->idpActivities = $talent->all_idpActivities;
        }

        if ($talent->improvementProjects->isEmpty() && $talent->all_improvementProjects->isNotEmpty()) {
            $talent->improvementProjects = $talent->all_improvementProjects;
        }

        $competencies = Competence::orderBy('id')->get();

        $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
        $standards = PositionTargetCompetence::where('position_id', $positionId)
            ->pluck('target_level', 'competence_id');

        return view('atasan.monitoring_detail_talent', compact('user', 'talent', 'competencies', 'standards'));
    }

    public function riwayatDetail(Request $request, $talentId)
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);
        $finalStatuses = ['Approved Panelis', 'Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'];
        $talent = User::with([
                'position',
                'department',
                'company',
                'mentor',
                'atasan',
                'promotion_plan.targetPosition',
                'assessmentSession.details.competence',
                'idpActivities.type',
                'improvementProjects',
                'all_promotion_plans.targetPosition',
                'all_promotion_plans.developmentSession.sourcePosition',
                'all_assessmentSessions.details.competence',
                'all_idpActivities.type',
                'all_improvementProjects'
            ])
            ->findOrFail($talentId);

        $requestedSessionId = $request->query('session_id');
        $archivedPlan = $requestedSessionId
            ? $talent->all_promotion_plans->firstWhere('development_session_id', (int) $requestedSessionId)
            : $talent->all_promotion_plans->first(function ($plan) use ($finalStatuses, $user) {
                return !$plan->is_active
                    && in_array($plan->status_promotion, $finalStatuses, true)
                    && (int) optional($plan->developmentSession)->atasan_id === (int) $user->id;
            });
        $sessionId = $archivedPlan?->development_session_id;

        if (!$archivedPlan || (int) optional($archivedPlan->developmentSession)->atasan_id !== (int) $user->id) {
            abort(404);
        }

        if ($archivedPlan) {
            $talent->promotion_plan = $archivedPlan;
            if ($archivedPlan->developmentSession?->sourcePosition) {
                $talent->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
            }
        }

        if ($sessionId) {
            $talent->assessmentSession = $talent->all_assessmentSessions->firstWhere('development_session_id', $sessionId);
            $talent->idpActivities = $talent->all_idpActivities->where('development_session_id', $sessionId)->values();
            $talent->improvementProjects = $talent->all_improvementProjects->where('development_session_id', $sessionId)->values();
        } elseif (!$talent->assessmentSession && $talent->all_assessmentSessions->isNotEmpty()) {
            $talent->assessmentSession = $talent->all_assessmentSessions->firstWhere('is_active', false) ?? $talent->all_assessmentSessions->first();
        }

        if (!$sessionId && $talent->idpActivities->isEmpty() && $talent->all_idpActivities->isNotEmpty()) {
            $talent->idpActivities = $talent->all_idpActivities;
        }

        if (!$sessionId && $talent->improvementProjects->isEmpty() && $talent->all_improvementProjects->isNotEmpty()) {
            $talent->improvementProjects = $talent->all_improvementProjects;
        }

        $competencies = Competence::orderBy('id')->get();

        $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
        $standards = PositionTargetCompetence::where('position_id', $positionId)
            ->pluck('target_level', 'competence_id');

        return view('atasan.riwayat_detail_talent', compact('user', 'talent', 'competencies', 'standards', 'sessionId'));
    }

    public function talentLogbookDetail(Request $request, $talentId)
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);
        $talent = User::with([
                'position',
                'department',
                'company',
                'idpActivities.type',
                'idpActivities.verifier',
                'all_idpActivities.type',
                'all_idpActivities.verifier',
                'all_promotion_plans.targetPosition',
                'all_promotion_plans.developmentSession.sourcePosition',
            ])
            ->findOrFail($talentId);

        $sessionId = $request->query('session_id');
        $archivedPlan = $sessionId
            ? $talent->all_promotion_plans->firstWhere('development_session_id', (int) $sessionId)
            : null;

        if ($archivedPlan) {
            if ((int) optional($archivedPlan->developmentSession)->atasan_id !== (int) $user->id) {
                abort(404);
            }

            $talent->promotion_plan = $archivedPlan;
            if ($archivedPlan->developmentSession?->sourcePosition) {
                $talent->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
            }
        } elseif ((int) $talent->atasan_id !== (int) $user->id) {
            abort(404);
        }

        $activities = $sessionId
            ? $talent->all_idpActivities->where('development_session_id', (int) $sessionId)->values()
            : ($talent->idpActivities->isNotEmpty()
                ? $talent->idpActivities
                : $talent->all_idpActivities);
        $idpTypes = IdpType::all();

        // Process data for tabs (similar to talent dashboard)
        $exposureData = $activities->where('type_idp', 1)->map(function ($act) {
            return [
                'id' => $act->id,
                'mentor' => $act->verifier->nama ?? '-',
                'tema' => $act->theme,
                'tanggal_update' => $act->updated_at,
                'tanggal' => $act->activity_date,
                'status' => $act->status,
            ];
        });

        $mentoringData = $activities->where('type_idp', 2)->map(function ($act) {
            return [
                'id' => $act->id,
                'mentor' => $act->verifier->nama ?? '-',
                'tema' => $act->theme,
                'tanggal_update' => $act->updated_at,
                'tanggal' => $act->activity_date,
                'status' => $act->status,
            ];
        });

        $learningData = $activities->where('type_idp', 3)->map(function ($act) {
            return [
                'id' => $act->id,
                'sumber' => $act->activity,
                'tema' => $act->theme,
                'tanggal_update' => $act->updated_at,
                'tanggal' => $act->activity_date,
                'status' => $act->status,
            ];
        });

        $activeTab = strtolower((string) $request->query('tab', 'exposure'));
        if (!in_array($activeTab, ['exposure', 'mentoring', 'learning'], true)) {
            $activeTab = 'exposure';
        }

        return view('atasan.logbook_detail_talent', compact('user', 'talent', 'exposureData', 'mentoringData', 'learningData', 'activeTab'));
    }
}
