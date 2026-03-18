<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\PromotionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDCAdminController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Fetch all talents with their relationships
        $talents = User::whereHas('role', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
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

        // Data for Development Plan form
        $companies = Company::orderBy('nama_company')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('role', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('role', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        return view('pdc_admin.dashboard', compact('user', 'groupedData', 'companies', 'positions', 'mentors', 'atasans'));
    }

    /**
     * Return talents filtered by company as JSON (for dynamic dropdown via fetch)
     */
    public function getTalentsByCompany(Request $request)
    {
        $companyId = $request->company_id;
        $talents = User::whereHas('role', fn($q) => $q->where('role_name', 'talent'))
            ->where('company_id', $companyId)
            ->orderBy('nama')
            ->get(['id', 'nama']);
        return response()->json($talents);
    }

    /**
     * Save Development Plan submitted from PDC Admin dashboard
     */
    public function storeDevelopmentPlan(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:company,id',
            'target_position_id' => 'required|exists:position,id',
            'atasan_id' => 'required|exists:users,id',
            'talents' => 'required|array|min:1',
            'talents.*.talent_id' => 'required|exists:users,id',
            'talents.*.mentors' => 'required|array|min:1',
            'talents.*.mentors.*' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->talents as $talentData) {
                $talentId = $talentData['talent_id'];
                $mentorIds = $talentData['mentors'];
                $primaryMentorId = $mentorIds[0] ?? null;

                // Update mentor & atasan on user (primary mentor only)
                User::where('id', $talentId)->update([
                    'mentor_id' => $primaryMentorId,
                    'atasan_id' => $request->atasan_id,
                ]);

                // Create or update promotion_plan with ALL mentor IDs
                PromotionPlan::updateOrCreate(
                ['user_id_talent' => $talentId],
                [
                    'target_position_id' => $request->target_position_id,
                    'mentor_ids' => $mentorIds, // all selected mentors
                    'status_promotion' => 'In Progress',
                    'start_date' => now(),
                    'target_date' => now()->addYear(),
                ]
                );
            }
        });

        return redirect()->route('pdc_admin.development_plan')
            ->with('success', 'Development Plan berhasil disimpan!');
    }

    public function developmentPlan()
    {
        $user = auth()->user();
        $companies = Company::orderBy('nama_company')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('role', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('role', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        return view('pdc_admin.development-plan', compact('user', 'companies', 'positions', 'mentors', 'atasans'));
    }

    public function detail($company_id, $position_id)
    {
        $user = auth()->user();
        $company = Company::findOrFail($company_id);
        $targetPosition = Position::findOrFail($position_id);

        $talents = User::where('company_id', $company_id)
            ->whereHas('promotion_plan', function ($q) use ($position_id) {
            $q->where('target_position_id', $position_id);
        })
            ->with(['department', 'position', 'mentor', 'atasan', 'assessmentSession.details.competence', 'idpActivities.type', 'improvementProjects.verifier'])
            ->get();

        $competencies = Competence::all();
        $standards = PositionTargetCompetence::where('position_id', $position_id)
            ->pluck('target_level', 'competence_id');

        return view('pdc_admin.detail', compact('user', 'company', 'targetPosition', 'talents', 'competencies', 'standards'));
    }

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
            'improvementProjects.verifier',
        ])->findOrFail($talent_id);

        // Build a single-item collection so the existing detail.blade.php loop still works
        $talents = collect([$talent]);

        $company = $talent->company;
        $targetPosition = optional($talent->promotion_plan)->targetPosition;

        $competencies = Competence::all();

        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ?PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        return view('pdc_admin.detail', compact('user', 'company', 'targetPosition', 'talents', 'competencies', 'standards'));
    }
}
