<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MentorValidasiTable extends Component
{
    public string $search = '';
    public string $activeTab = 'exposure';
    public int $selectedTalentId = 0;

    public function mount(): void
    {
        $this->selectedTalentId = (int)request('talent_id', 0);
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function selectTalent(int $id): void
    {
        $this->selectedTalentId = $id;
        $this->search = '';
    }

    public function render()
    {
        $user = Auth::user();
        $mentees = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q->whereJsonContains('mentor_ids', $user->id)
        ->orWhere('mentor_id', $user->id))
            ->get();

        $selectedTalent = null;
        $exposureData = collect();
        $mentoringData = collect();
        $learningData = collect();

        if ($this->selectedTalentId) {
            $selectedTalent = $mentees->find($this->selectedTalentId);
        }

        if ($selectedTalent) {
            $activities = $selectedTalent->developmentActivities()
                ->with(['mentor'])
                ->get();

            $exposureData = $activities->where('type', 'exposure')->values();
            $mentoringData = $activities->where('type', 'mentoring')->values();
            $learningData = $activities->where('type', 'learning')->values();
        }

        return view('livewire.mentor-validasi-table', compact(
            'mentees', 'selectedTalent',
            'exposureData', 'mentoringData', 'learningData'
        ));
    }
}
