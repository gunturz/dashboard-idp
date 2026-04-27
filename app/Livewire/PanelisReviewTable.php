<?php

namespace App\Livewire;

use App\Models\ImprovementProject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PanelisReviewTable extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = ImprovementProject::with(['talent', 'talent.position', 'talent.department', 'talent.assessmentSession.details'])
            ->where('status', 'Pending')
            ->when($this->search, fn($q) => $q->where(function ($q2) {
            $q2->where('title', 'like', "%{$this->search}%")
                ->orWhereHas('talent', fn($q3) => $q3->where('nama', 'like', "%{$this->search}%"));
        }
        ))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.panelis-review-table', ['projects' => $projects]);
    }
}
