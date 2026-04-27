<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class PdcProgressTalentTable extends Component
{
    public string $search = '';

    // Delete modal
    public bool $showDeleteModal = false;
    public string $deleteAction = '';
    public string $deletePositionName = '';

    public function openDeleteModal(string $action, string $positionName): void
    {
        $this->deleteAction = $action;
        $this->deletePositionName = $positionName;
        $this->showDeleteModal = true;
    }

    public function render()
    {
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->whereHas('promotion_plan', function ($q) {
            $q->whereNotNull('target_position_id')
                ->whereNotIn('status_promotion', ['Approved Panelis', 'Promoted', 'Not Promoted']);
        })
            ->join('promotion_plan', 'users.id', '=', 'promotion_plan.user_id_talent')
            ->select('users.*')
            ->orderBy('promotion_plan.created_at', 'desc')
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->when($this->search, function ($q) {
            $q->where('users.nama', 'like', '%' . $this->search . '%');
        })
            ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
        $groupedData = $talents->groupBy('company_id')
            ->map(function ($companyTalents) {
            $sorted = $companyTalents->sortByDesc(function ($talent) {
                    return optional($talent->promotion_plan)->created_at ?? $talent->created_at;
                }
                )->values();

                return [
                'company' => $sorted->first()->company,
                'latest_plan_at' => $sorted->max(fn($t) => optional($t->promotion_plan)->created_at ?? $t->created_at),
                'positions' => $sorted->groupBy(fn($item) => $item->promotion_plan->target_position_id ?? 0)
                ->map(function ($positionTalents) {
                    $sortedPos = $positionTalents->sortByDesc(fn($t) => optional($t->promotion_plan)->created_at ?? $t->created_at)->values();
                    return [
                    'targetPosition' => optional($sortedPos->first()->promotion_plan)->targetPosition ?? null,
                    'talents' => $sortedPos,
                    ];
                }
                ),
                ];
            })
            ->sortByDesc('latest_plan_at');

        $totalTalent = $talents->count();
        $totalCompany = $groupedData->count();
        $totalPositions = $groupedData->sum(fn($c) => $c['positions']->count());

        return view('livewire.pdc-progress-talent-table', compact(
            'groupedData',
            'totalTalent',
            'totalCompany',
            'totalPositions'
        ));
    }
}
