<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Department;
use App\Models\ImprovementProject;
use App\Models\PanelisAssessment;
use App\Models\PromotionPlan;
use Livewire\Component;

class PdcPanelisReviewTable extends Component
{
    public string $search = '';
    public string $companyFilter = '';
    public string $positionFilter = '';
    public string $departmentFilter = '';

    // Computed: department options yang tersedia berdasarkan company terpilih
    public function getDepartmentsForFilterProperty()
    {
        if (!$this->companyFilter) {
            return collect();
        }
        return Department::where('company_id', $this->companyFilter)
            ->orderBy('nama_department')
            ->get();
    }

    // Reset department filter jika company berubah
    public function updatedCompanyFilter(): void
    {
        $this->departmentFilter = '';
    }

    public function getGroupedDataProperty()
    {
        $query = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q
        ->whereNotNull('target_position_id')
        ->whereNotIn('status_promotion', ['Approved Panelis', 'Promoted', 'Not Promoted'])
        )
            ->with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
            'improvementProjects',
        ]);

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }
        if ($this->companyFilter) {
            $query->where('company_id', $this->companyFilter);
        }
        if ($this->positionFilter) {
            $query->whereHas('promotion_plan', fn($q) => $q->where('target_position_id', $this->positionFilter));
        }
        if ($this->departmentFilter) {
            $query->where('department_id', $this->departmentFilter);
        }

        $talents = $query->get()
            ->sortByDesc(fn($t) =>
        optional($t->improvementProjects->sortByDesc('created_at')->first())->created_at
        ?? optional($t->promotion_plan)->created_at
        ?? $t->created_at
        )
            ->values();

        return $talents->groupBy('company_id')
            ->map(function ($companyTalents) {
            $sorted = $companyTalents->sortByDesc(fn($t) =>
            optional($t->improvementProjects->sortByDesc('created_at')->first())->created_at
            ?? optional($t->promotion_plan)->created_at
            ?? $t->created_at
            )->values();

            return [
                'company' => $sorted->first()->company,
                'latest_project_at' => $sorted->max(fn($t) =>
            optional($t->improvementProjects->sortByDesc('created_at')->first())->created_at
            ?? optional($t->promotion_plan)->created_at
            ?? $t->created_at
            ),
                'positions' => $sorted->groupBy(fn($item) => $item->promotion_plan->target_position_id ?? 0)
                ->map(function ($positionTalents) {
                $sortedPos = $positionTalents->sortByDesc(fn($t) =>
                optional($t->improvementProjects->sortByDesc('created_at')->first())->created_at
                ?? optional($t->promotion_plan)->created_at
                ?? $t->created_at
                )->values();
                return [
                        'targetPosition' => $sortedPos->first()->promotion_plan->targetPosition ?? null,
                        'talents' => $sortedPos,
                    ];
            }
            ),
            ];
        })
            ->sortByDesc('latest_project_at');
    }

    public function getStatsProperty(): array
    {
        $totalProjectImprovement = ImprovementProject::count();

        $allTalents = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q->whereNotNull('target_position_id'))
            ->with(['promotion_plan', 'improvementProjects'])
            ->get();

        $belumDinilai = 0;
        $sudahDinilai = 0;

        foreach ($allTalents as $talent) {
            $alreadySent = in_array(
                optional($talent->promotion_plan)->status_promotion,
            ['Pending Panelis', 'Approved Panelis', 'Rejected Panelis']
            );
            $isReviewedByPanelis = PanelisAssessment::where('user_id_talent', $talent->id)->exists();

            if (in_array(optional($talent->promotion_plan)->status_promotion, ['Approved Panelis', 'Promoted', 'Not Promoted'])) {
                $sudahDinilai++;
            }
            if ($alreadySent && !$isReviewedByPanelis) {
                $belumDinilai++;
            }
        }

        return compact('totalProjectImprovement', 'belumDinilai', 'sudahDinilai');
    }

    public function render()
    {
        $companies = Company::orderBy('nama_company')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();
        $panelisUsers = User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bo_director', 'panelis', 'board_of_directors', 'board_of_director']))
            ->with(['company', 'position'])
            ->orderBy('nama')
            ->get();

        return view('livewire.pdc-panelis-review-table', [
            'companies' => $companies,
            'positions' => $positions,
            'panelisUsers' => $panelisUsers,
            'groupedData' => $this->groupedData,
            'stats' => $this->stats,
            'departmentsForFilter' => $this->departmentsForFilter,
        ]);
    }
}
