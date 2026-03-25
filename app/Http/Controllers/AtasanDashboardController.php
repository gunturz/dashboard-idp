<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;

class AtasanDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user()->load(['company', 'department', 'position', 'role']);

        // Fetch subordinates (talents under this atasan)
        $talents = User::where('atasan_id', $user->id)
            ->with([
                'position',
                'department',
                'promotion_plan.targetPosition',
                'assessmentSession.details.competence',
            ])
            ->get();

        // Summary stats
        $totalTalents = $talents->count();

        // Assessment Pending = talents where atasan has NOT scored yet (score_atasan is all 0)
        $assessmentPending = 0;
        $onTrack = 0;

        foreach ($talents as $talent) {
            $session = $talent->assessmentSession;
            if (!$session || !$session->details || $session->details->isEmpty()) {
                // No assessment session at all — not pending (talent hasn't done self-assessment)
                continue;
            }

            $totalAtasanScore = $session->details->sum('score_atasan');
            if ($totalAtasanScore == 0) {
                $assessmentPending++;
            } else {
                $onTrack++;
            }
        }

        // Competencies and standards
        $competencies = Competence::orderBy('id')->get();

        // Build standards lookup: for each talent, get their target position standards
        $allStandards = [];
        foreach ($talents as $talent) {
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
            ->where('user_id_atasan', $user->id)
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

        return back()->with('success', 'Assessment berhasil disimpan.');
    }
}
