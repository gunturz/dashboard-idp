<?php

namespace App\Livewire;

use App\Models\IdpActivity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MentorValidasiTable extends Component
{
    public string $search = '';
    public array $talentActiveTabs = [];
    public int $selectedTalentId = 0;
    public bool $showOnlyPending = false;
    public string $requestedTab = '';
    public int $focusedTalentId = 0;

    public function mount(): void
    {
        $this->selectedTalentId = (int) request('talent_id', 0);
        $this->showOnlyPending = (bool) request('pending_only', false);
        $this->requestedTab = (string) request('tab', '');
        $this->focusedTalentId = (int) request('focus_talent_id', 0);
    }

    public function switchTab(string $tab, int $talentId): void
    {
        $this->talentActiveTabs[$talentId] = $tab;
    }

    public function getActiveTab(int $talentId): string
    {
        return $this->talentActiveTabs[$talentId] ?? 'exposure';
    }

    public function selectTalent(int $id): void
    {
        $this->selectedTalentId = $id;
        $this->search = '';
    }

    protected function isPendingStatus(?string $status): bool
    {
        return $status === 'Pending' || $status === null || $status === '';
    }

    protected function statusPriority(?string $status): int
    {
        if ($this->isPendingStatus($status)) {
            return 0;
        }

        if (in_array($status, ['Approve', 'Approved'], true)) {
            return 1;
        }

        return 2;
    }

    protected function rowTimestamp(array $row): int
    {
        $date = $row['tanggal_update'] ?? $row['tanggal'] ?? null;

        return $date ? (strtotime((string) $date) ?: 0) : 0;
    }

    protected function sortRows(array $rows): array
    {
        usort($rows, function (array $a, array $b) {
            $priorityCompare = $this->statusPriority($a['status'] ?? null) <=> $this->statusPriority($b['status'] ?? null);

            if ($priorityCompare !== 0) {
                return $priorityCompare;
            }

            return $this->rowTimestamp($b) <=> $this->rowTimestamp($a);
        });

        return $rows;
    }

    protected function resolvePendingTab($exposureData, $mentoringData, $learningData): string
    {
        if ($exposureData->contains(fn ($row) => $this->isPendingStatus($row['status'] ?? null))) {
            return 'exposure';
        }

        if ($mentoringData->contains(fn ($row) => $this->isPendingStatus($row['status'] ?? null))) {
            return 'mentoring';
        }

        if ($learningData->contains(fn ($row) => $this->isPendingStatus($row['status'] ?? null))) {
            return 'learning';
        }

        if ($exposureData->isNotEmpty()) {
            return 'exposure';
        }

        if ($mentoringData->isNotEmpty()) {
            return 'mentoring';
        }

        if ($learningData->isNotEmpty()) {
            return 'learning';
        }

        return 'exposure';
    }

    protected function hasPendingRows($exposureRows, $mentoringRows, $learningRows): bool
    {
        return collect([$exposureRows, $mentoringRows, $learningRows])
            ->contains(fn ($rows) => $rows->contains(fn ($row) => $this->isPendingStatus($row['status'] ?? null)));
    }

    public function render()
    {
        $user = Auth::user();
        $rawMentees = $user->mentees;

        $activitiesByTalent = IdpActivity::with(['type', 'verifier', 'talent'])
            ->whereIn('user_id_talent', $rawMentees->pluck('id'))
            ->where(function ($q) use ($user) {
                $q->where('verify_by', $user->id)
                    ->orWhereHas('type', function ($qType) {
                        $qType->where('type_name', 'Learning');
                    });
            })
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id_talent');

        $mentees = $rawMentees
            ->filter(fn ($mentee) => $activitiesByTalent->has($mentee->id))
            ->sortByDesc(function ($mentee) use ($activitiesByTalent) {
                return optional($activitiesByTalent->get($mentee->id)?->max('updated_at'))?->timestamp ?? 0;
            })
            ->values();

        $selectedTalent = null;
        $exposureData = collect();
        $mentoringData = collect();
        $learningData = collect();
        $showAllTalents = $this->selectedTalentId === 0;

        if (!$showAllTalents && $this->selectedTalentId) {
            $selectedTalent = $mentees->find($this->selectedTalentId);
        }

        if ($showAllTalents || $selectedTalent) {
            $activities = $showAllTalents
                ? $activitiesByTalent->flatten(1)->sortByDesc(function ($act) {
                    return optional($act->updated_at ?? $act->created_at)?->timestamp ?? 0;
                })->values()
                : ($activitiesByTalent->get($selectedTalent->id)?->sortByDesc(function ($act) {
                    return optional($act->updated_at ?? $act->created_at)?->timestamp ?? 0;
                })->values() ?? collect());

            $expArr = [];
            $menArr = [];
            $leaArr = [];

            foreach ($activities as $act) {
                $typeName = $act->type ? $act->type->type_name : '';

                $docPaths = [];
                $docNames = [];
                if ($act->document_path) {
                    if (str_starts_with($act->document_path, '["')) {
                        $docPaths = json_decode($act->document_path, true) ?? [];
                        $docNames = $act->file_name ? explode(', ', $act->file_name) : [];
                    } else {
                        $docPaths = [$act->document_path];
                        $docNames = [$act->file_name ?? ''];
                    }
                }

                if ($typeName === 'Exposure') {
                    $expArr[] = [
                        'id' => $act->id,
                        'talent_id' => $act->user_id_talent,
                        'talent_name' => optional($act->talent)->nama ?? '-',
                        'mentor' => $act->verifier ? $act->verifier->nama : '-',
                        'tema' => $act->theme,
                        'tanggal_update' => $act->updated_at,
                        'tanggal' => $act->activity_date,
                        'lokasi' => $act->location,
                        'aktivitas' => $act->activity,
                        'deskripsi' => $act->description,
                        'file_paths' => $docPaths,
                        'file_names' => $docNames,
                        'status' => $act->status,
                    ];
                } elseif ($typeName === 'Mentoring') {
                    $menArr[] = [
                        'id' => $act->id,
                        'talent_id' => $act->user_id_talent,
                        'talent_name' => optional($act->talent)->nama ?? '-',
                        'mentor' => $act->verifier ? $act->verifier->nama : '-',
                        'tema' => $act->theme,
                        'tanggal_update' => $act->updated_at,
                        'tanggal' => $act->activity_date,
                        'lokasi' => $act->location,
                        'deskripsi' => $act->description,
                        'action_plan' => $act->action_plan,
                        'file_paths' => $docPaths,
                        'file_names' => $docNames,
                        'status' => $act->status,
                    ];
                } elseif ($typeName === 'Learning') {
                    $leaArr[] = [
                        'id' => $act->id,
                        'talent_id' => $act->user_id_talent,
                        'talent_name' => optional($act->talent)->nama ?? '-',
                        'sumber' => $act->activity,
                        'tema' => $act->theme,
                        'tanggal_update' => $act->updated_at,
                        'tanggal' => $act->activity_date,
                        'platform' => $act->platform,
                        'file_paths' => $docPaths,
                        'file_names' => $docNames,
                        'status' => $act->status,
                    ];
                }
            }

            $exposureData = collect($this->sortRows($expArr));
            $mentoringData = collect($this->sortRows($menArr));
            $learningData = collect($this->sortRows($leaArr));

            if ($showAllTalents) {
                $allTalentIds = collect()
                    ->merge($exposureData->pluck('talent_id'))
                    ->merge($mentoringData->pluck('talent_id'))
                    ->merge($learningData->pluck('talent_id'))
                    ->unique()
                    ->values();

                foreach ($allTalentIds as $talentId) {
                    if (!empty($this->talentActiveTabs[$talentId])) {
                        continue;
                    }

                    $this->talentActiveTabs[$talentId] = $this->resolvePendingTab(
                        $exposureData->where('talent_id', $talentId)->values(),
                        $mentoringData->where('talent_id', $talentId)->values(),
                        $learningData->where('talent_id', $talentId)->values()
                    );
                }
            } elseif ($selectedTalent) {
                $talentId = $selectedTalent->id;

                if (
                    !empty($this->requestedTab)
                    && in_array($this->requestedTab, ['exposure', 'mentoring', 'learning'], true)
                    && empty($this->talentActiveTabs[$talentId])
                ) {
                    $this->talentActiveTabs[$talentId] = $this->requestedTab;
                }

                if (empty($this->talentActiveTabs[$talentId])) {
                    $this->talentActiveTabs[$talentId] = $this->resolvePendingTab($exposureData, $mentoringData, $learningData);
                }
            }
        }

        return view('livewire.mentor-validasi-table', [
            'mentees' => $mentees,
            'selectedTalent' => $selectedTalent,
            'showAllTalents' => $showAllTalents,
            'exposureData' => $exposureData,
            'mentoringData' => $mentoringData,
            'learningData' => $learningData,
            'talentActiveTabs' => $this->talentActiveTabs,
            'focusedTalentId' => $this->focusedTalentId,
        ]);
    }
}
