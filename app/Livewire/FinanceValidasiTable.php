<?php

namespace App\Livewire;

use App\Models\ImprovementProject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceValidasiTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = ''; // '', 'Pending', 'Approved', 'Rejected'
    public int $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = ImprovementProject::with(['talent', 'talent.position', 'talent.department', 'talent.promotion_plan.targetPosition'])
            ->where('verify_by', Auth::id())
            ->whereNotNull('feedback')
            ->where(function ($q) {
            $q->where('status', 'Pending')
                ->orWhereNotNull('finance_feedback');
        })
            ->when($this->search, fn($q) => $q->where(function ($q2) {
            $q2->where('title', 'like', "%{$this->search}%")
                ->orWhereHas('talent', fn($q3) => $q3->where('nama', 'like', "%{$this->search}%"));
        }
        ))
            ->when($this->statusFilter, function ($q) {
            $mappedStatus = $this->statusFilter === 'Approved' ? 'Verified' : $this->statusFilter;
            $q->where('status', $mappedStatus);
        })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.finance-validasi-table', ['projects' => $projects]);
    }
}
