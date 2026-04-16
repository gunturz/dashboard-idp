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
        $allTalents = User::where('atasan_id', $user->id)
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
            }
            else {
                $onTrack++;
            }
        }

        // Only show talents that have NOT been assessed by atasan yet
        $talents = $allTalents->filter(function ($talent) {
            $session = $talent->assessmentSession;
            if (!$session || !$session->details || $session->details->isEmpty()) {
                return true; // Belum ada sesi assessment — tampilkan
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
            'user', 'talents', 'totalTalents', 'assessmentPending', 'onTrack',
            'competencies', 'allStandards'
        ));
    }

    public function monitoring()
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);

        $talents = User::where('atasan_id', $user->id)
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
        $talent = User::where('atasan_id', $user->id)->findOrFail($talentId);

        $competencies = Competence::with(['questions' => function ($q) {
            $q->orderBy('level');
        }])->get();

        return view('atasan.competency_atasan', compact('user', 'talent', 'competencies'));
    }

    public function storeAssessment(Request $request, $talentId)
    {
        $user = Auth::user();

        // Validate scores
        $data = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:0|max:5',
        ]);

        // Find the assessment session for this talent
        $session = DB::table('assessment_session')
            ->where('user_id_talent', $talentId)
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

        // Tambah notifikasi ke sistem
        $this->addNotificationToUser(
            $user->id,
            "Assessment Tersimpan",
            "Anda telah berhasil memberikan penilaian assessment untuk talent <b>{$talent->nama}</b>.",
            "success"
        );

        return redirect()->route('atasan.riwayat')->with('open_bell_notif', true);
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
        $search      = $request->input('search');
        $filterPeriode    = $request->input('periode');
        $filterPerusahaan = $request->input('perusahaan');
        $filterDepartemen = $request->input('departemen');

        $talentsQuery = User::where('atasan_id', $user->id)
            ->with([
            'position',
            'department',
            'company',
            'promotion_plan.targetPosition',
            'assessmentSession.details.competence',
            'improvementProjects'
        ]);

        if ($search) {
            $talentsQuery->where('nama', 'like', '%' . $search . '%');
        }

        $talents = $talentsQuery->get();
        $competencies = Competence::orderBy('id')->get();

        // Build filter options
        $periodeOptions = $talents
            ->filter(fn($t) => $t->promotion_plan && $t->promotion_plan->start_date && $t->promotion_plan->target_date)
            ->map(fn($t) => $t->promotion_plan->start_date->format('Y') . '/' . $t->promotion_plan->target_date->format('Y'))
            ->unique()->values();

        $perusahaanOptions = $talents->map(fn($t) => $t->company?->nama_perusahaan ?? null)->filter()->unique()->values();
        $departemenOptions = $talents->map(fn($t) => $t->department?->nama_department ?? null)->filter()->unique()->values();

        // Apply filters in PHP
        if ($filterPeriode) {
            $talents = $talents->filter(function ($t) use ($filterPeriode) {
                if (!$t->promotion_plan || !$t->promotion_plan->start_date || !$t->promotion_plan->target_date) return false;
                $key = $t->promotion_plan->start_date->format('Y') . '/' . $t->promotion_plan->target_date->format('Y');
                return $key === $filterPeriode;
            })->values();
        }
        if ($filterPerusahaan) {
            $talents = $talents->filter(fn($t) => ($t->company?->nama_perusahaan ?? '') === $filterPerusahaan)->values();
        }
        if ($filterDepartemen) {
            $talents = $talents->filter(fn($t) => ($t->department?->nama_department ?? '') === $filterDepartemen)->values();
        }

        return view('atasan.riwayat', compact(
            'user', 'talents', 'competencies', 'search',
            'filterPeriode', 'filterPerusahaan', 'filterDepartemen',
            'periodeOptions', 'perusahaanOptions', 'departemenOptions'
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
            'improvementProjects'
        ])
            ->findOrFail($talentId);

        $competencies = Competence::orderBy('id')->get();

        $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
        $standards = PositionTargetCompetence::where('position_id', $positionId)
            ->pluck('target_level', 'competence_id');

        return view('atasan.monitoring_detail_talent', compact('user', 'talent', 'competencies', 'standards'));
    }

    public function talentLogbookDetail($talentId)
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);
        $talent = User::where('atasan_id', $user->id)
            ->with([
            'idpActivities.type',
            'idpActivities.verifier',
        ])
            ->findOrFail($talentId);

        $activities = $talent->idpActivities;
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
            'sumber' => $act->location,
            'tema' => $act->theme,
            'tanggal_update' => $act->updated_at,
            'tanggal' => $act->activity_date,
            'status' => $act->status,
            ];
        });

        return view('atasan.logbook_detail_talent', compact('user', 'talent', 'exposureData', 'mentoringData', 'learningData'));
    }
}
