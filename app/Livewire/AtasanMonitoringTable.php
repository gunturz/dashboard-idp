<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Competence;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AtasanMonitoringTable extends Component
{
    public string $search = '';
    public string $activeSection = 'kompetensi'; // kompetensi, idp, project, logbook
    public int $activeLogbookType = 1; // 1: exposure, 2: mentoring, 3: learning

    public function mount(): void
    {
        $requestedSection = request()->query('activeSection');
        $allowedSections = ['kompetensi', 'idp', 'project', 'logbook'];

        if (in_array($requestedSection, $allowedSections, true)) {
            $this->activeSection = $requestedSection;
        }

        $requestedType = (int) request()->query('activeLogbookType', 1);
        if (in_array($requestedType, [1, 2, 3], true)) {
            $this->activeLogbookType = $requestedType;
        }
    }

    public function switchSection($section)
    {
        $this->activeSection = $section;
    }

    public function filterLog($type)
    {
        $this->activeLogbookType = $type;
    }

    public function render()
    {
        $user = Auth::user();

        $talentQuery = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q->where('atasan_id', $user->id))
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('nama', 'like', "%{$this->search}%")
                        ->orWhereHas('position', fn($q3) => $q3->where('position_name', 'like', "%{$this->search}%"));
                });
            })
            ->with([
                'department',
                'position',
                'mentor',
                'promotion_plan',
            ]);

        if ($this->activeSection === 'kompetensi') {
            $talentQuery->with(['assessmentSession.details.competence']);
        }

        if (in_array($this->activeSection, ['idp', 'logbook'], true)) {
            $talentQuery->with(['idpActivities.verifier']);
        }

        if ($this->activeSection === 'project') {
            $talentQuery->with(['improvementProjects']);
        }

        $talents = $talentQuery->get();

        $competencies = collect();
        $standards = collect();

        if ($this->activeSection === 'kompetensi') {
            $competencies = Competence::all();
            $targetPositionIds = $talents->map(fn($t) => optional($t->promotion_plan)->target_position_id)->filter()->unique();

            if ($targetPositionIds->isNotEmpty()) {
                $standards = \DB::table('position_target_competence')
                    ->whereIn('position_id', $targetPositionIds)
                    ->selectRaw('competence_id, AVG(target_level) as standard_score')
                    ->groupBy('competence_id')
                    ->pluck('standard_score', 'competence_id');
            }
        }

        return view('livewire.atasan-monitoring-table', [
            'talents' => $talents,
            'competencies' => $competencies,
            'standards' => $standards,
            'user' => $user
        ]);
    }
}
