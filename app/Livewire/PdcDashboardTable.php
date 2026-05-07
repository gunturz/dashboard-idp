<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\PromotionPlan;
use Livewire\Component;

class PdcDashboardTable extends Component
{
    public string $search = '';

    public function getTableRowsProperty(): array
    {
        // Menampilkan semua talent aktif dalam siklus promosi (belum Promoted/Not Promoted)
        $talents = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q
                ->whereNotNull('target_position_id')
                ->whereNotIn('status_promotion', ['Promoted', 'Not Promoted'])
                ->where('is_active', true)
            )
            ->join('promotion_plan', function ($join) {
                $join->on('users.id', '=', 'promotion_plan.user_id_talent')
                     ->where('promotion_plan.is_active', true);
            })
            ->select('users.*')
            ->orderBy('promotion_plan.updated_at', 'desc')
            ->orderBy('promotion_plan.created_at', 'desc')
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->when($this->search, fn($q) => $q->where('users.nama', 'like', '%' . $this->search . '%'))
            ->take(8)
            ->get();

        $rows = [];
        $grouped = $talents->groupBy('company_id')->map(function ($companyTalents) {
            return [
            'company' => $companyTalents->first()->company,
            'positions' => $companyTalents->groupBy(fn($item) => $item->promotion_plan->target_position_id ?? 0)
            ->map(fn($positionTalents) => [
            'targetPosition' => $positionTalents->first()->promotion_plan->targetPosition ?? null,
            'talents' => $positionTalents,
            ]),
            ];
        });

        foreach ($grouped as $companyId => $companyData) {
            foreach ($companyData['positions'] as $positionId => $posData) {
                foreach ($posData['talents'] as $talent) {
                    $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                    if (!empty($mentorIds)) {
                        $mentorNames = User::whereIn('id', $mentorIds)->pluck('nama')->toArray();
                        $mentorStr = implode(', ', $mentorNames) ?: '-';
                    }
                    else {
                        $mentorStr = optional($talent->mentor)->nama ?? '-';
                    }
                    $rows[] = [
                        'position' => optional($posData['targetPosition'])->position_name ?? '-',
                        'dept' => optional($talent->department)->nama_department ?? '-',
                        'talent' => $talent->nama,
                        'role' => optional($talent->position)->position_name ?? 'Officer',
                        'mentor' => $mentorStr,
                        'atasan' => optional($talent->atasan)->nama ?? '-',
                    ];
                }
            }
        }

        return $rows;
    }

    public function render()
    {
        return view('livewire.pdc-dashboard-table', [
            'tableRows' => $this->tableRows,
        ]);
    }
}
