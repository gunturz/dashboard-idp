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
    public string $deleteTalentNames = '';

    public function openDeleteModal(string $action, string $positionName, string $talentNames = ''): void
    {
        $this->deleteAction = $action;
        $this->deletePositionName = $positionName;
        $this->deleteTalentNames = $talentNames;
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
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->when($this->search, function ($q) {
                $q->where('users.nama', 'like', '%' . $this->search . '%');
            })
            ->get();

        // Grouping: Company ID -> Plan Session + Department + Target Position -> Talents
        $groupedData = $talents->groupBy('company_id')
            ->map(function ($companyTalents) {
                $sorted = $companyTalents->sortByDesc(
                    function ($talent) {
                        return optional($talent->promotion_plan)->created_at ?? $talent->created_at;
                    }
                )->values();

                return [
                    'company' => $sorted->first()->company,
                    'latest_plan_at' => $sorted->max(fn($t) => optional($t->promotion_plan)->created_at ?? $t->created_at),
                    'plan_groups' => $sorted->groupBy(function ($item) {
                        $plan = $item->promotion_plan;
                        $planCreatedAt = optional($plan?->created_at)->format('Y-m-d H:i:s') ?? 'no-plan';

                        return implode('|', [
                            $plan?->target_position_id ?? 0,
                            $item->department_id ?? 0,
                            $planCreatedAt,
                        ]);
                    })->map(
                            function ($groupTalents) {
                                $sortedPos = $groupTalents->sortByDesc(fn($t) => optional($t->promotion_plan)->created_at ?? $t->created_at)->values();
                                $firstTalent = $sortedPos->first();
                                $plan = optional($firstTalent)->promotion_plan;

                                return [
                                    'targetPosition' => optional($plan)->targetPosition,
                                    'target_position_id' => $plan?->target_position_id,
                                    'department_id' => $firstTalent?->department_id,
                                    'department_name' => optional($firstTalent?->department)->nama_department ?? '-',
                                    'plan_created_at' => optional($plan?->created_at)?->format('Y-m-d H:i:s'),
                                    'start_date' => optional($plan?->start_date)?->format('Y-m-d'),
                                    'target_date' => optional($plan?->target_date)?->format('Y-m-d'),
                                    'talents' => $sortedPos,
                                ];
                            }
                        ),
                ];
            })
            ->sortByDesc('latest_plan_at');

        $totalTalent = $talents->count();
        $totalCompany = $groupedData->count();
        $totalPositions = $groupedData->sum(fn($c) => $c['plan_groups']->count());

        return view('livewire.pdc-progress-talent-table', compact(
            'groupedData',
            'totalTalent',
            'totalCompany',
            'totalPositions'
        ));
    }
}
