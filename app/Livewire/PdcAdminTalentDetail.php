<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class PdcAdminTalentDetail extends Component
{
    public $user;
    public $company;
    public $targetPosition;
    public $competencies;
    public $standards;
    public $financeUsers;
    public array $talentIds = [];

    public $activeTab = 'kompetensi';
    public $logbookFilterType = null;
    public $activeLogbookSection = 'logbookDropdownIdp'; // Can be used if logbook has sub-filters

    // Accept the required properties from the Blade component caller
    public function mount($user, $company, $targetPosition, $talents, $competencies, $standards, $financeUsers)
    {
        $this->user = $user;
        $this->company = $company;
        $this->targetPosition = $targetPosition;
        $this->competencies = $competencies;
        $this->standards = $standards;
        $this->financeUsers = $financeUsers;
        $this->talentIds = collect($talents)->pluck('id')->map(fn($id) => (int) $id)->all();
    }

    public function setTab($tabName)
    {
        $this->activeTab = $tabName;
    }

    public function setLogbookFilter($typeId)
    {
        $this->activeTab = 'logbook';
        $this->logbookFilterType = $typeId;
    }

    protected function loadTalentsForActiveTab(): Collection
    {
        if (empty($this->talentIds)) {
            return new Collection();
        }

        $query = User::query()
            ->whereIn('id', $this->talentIds)
            ->with([
                'department',
                'position',
                'mentor',
                'atasan',
                'promotion_plan.targetPosition',
            ]);

        if ($this->activeTab === 'kompetensi') {
            $query->with(['assessmentSession.details.competence']);
        }

        if (in_array($this->activeTab, ['idp', 'logbook'], true)) {
            $query->with(['idpActivities.type', 'idpActivities.verifier']);
        }

        if ($this->activeTab === 'project') {
            $query->with(['improvementProjects.verifier']);
        }

        $talents = $query->get()->keyBy('id');

        return collect($this->talentIds)
            ->map(fn($id) => $talents->get($id))
            ->filter()
            ->values();
    }

    protected function buildGapPayload(Collection $talents): array
    {
        if ($this->activeTab !== 'kompetensi') {
            return [];
        }

        return $talents->map(function ($talent) {
            if (!$talent->assessmentSession) {
                return [
                    'talent_id' => $talent->id,
                    'reason' => '',
                    'gaps' => [],
                ];
            }

            $details = $talent->assessmentSession->details;
            $overrides = $details->filter(function ($d) {
                return str_starts_with($d->notes ?? '', 'priority_');
            })->sortBy(function ($d) {
                return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
            });

            $reasonOverride = '';
            $selectedIds = [];

            if ($overrides->count() > 0) {
                $parts = explode('|', $overrides->first()->notes, 2);
                $reasonOverride = $parts[1] ?? '';
                $selectedIds = $overrides->pluck('competence_id')->toArray();
            } else {
                $selectedIds = $details->sortBy('gap_score')->take(3)->pluck('competence_id')->toArray();
            }

            return [
                'talent_id' => $talent->id,
                'reason' => $reasonOverride,
                'gaps' => $details->map(function ($d) use ($selectedIds) {
                    $pIndex = array_search($d->competence_id, $selectedIds);

                    return [
                        'id' => $d->competence_id,
                        'name' => $d->competence->name,
                        'score' => ($d->score_talent + $d->score_atasan) / 2,
                        'standard' => $this->standards[$d->competence_id] ?? 0,
                        'gap' => (float) $d->gap_score,
                        'selected' => $pIndex !== false,
                        'priority' => $pIndex !== false ? $pIndex + 1 : 999,
                    ];
                })->sortBy('gap')->values()->toArray(),
            ];
        })->values()->toArray();
    }

    public function render()
    {
        $talents = $this->loadTalentsForActiveTab();

        return view('livewire.pdc-admin-talent-detail', [
            'talents' => $talents,
            'allTalentGapsData' => $this->buildGapPayload($talents),
        ]);
    }
}
