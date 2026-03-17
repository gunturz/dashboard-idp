<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\DetailAssessment;
use Illuminate\Http\Request;

class PDCAdminController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Fetch all talents with their relationships
        $talents = User::whereHas('role', function($q) {
            $q->where('role_name', 'talent');
        })
        ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
        ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
        $groupedData = $talents->groupBy('company_id')->map(function($companyTalents) {
            return [
                'company' => $companyTalents->first()->company,
                'positions' => $companyTalents->groupBy(function($item) {
                    return $item->promotion_plan->target_position_id ?? 0;
                })->map(function($positionTalents) {
                    return [
                        'targetPosition' => $positionTalents->first()->promotion_plan->targetPosition ?? null,
                        'talents' => $positionTalents
                    ];
                })
            ];
        });

        return view('pdc_admin.dashboard', compact('user', 'groupedData'));
    }

    public function detail($company_id, $position_id)
    {
        $user = auth()->user();
        $company = Company::findOrFail($company_id);
        $targetPosition = Position::findOrFail($position_id);

        $talents = User::where('company_id', $company_id)
            ->whereHas('promotion_plan', function($q) use ($position_id) {
                $q->where('target_position_id', $position_id);
            })
            ->with(['department', 'position', 'mentor', 'atasan', 'assessmentSession.details.competence', 'idpActivities.type', 'improvementProjects.verifier'])
            ->get();

        $competencies = Competence::all();
        $standards = PositionTargetCompetence::where('position_id', $position_id)
            ->pluck('target_level', 'competence_id');

        return view('pdc_admin.detail', compact('user', 'company', 'targetPosition', 'talents', 'competencies', 'standards'));
    }
}
