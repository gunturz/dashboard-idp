<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ImprovementProject;
use App\Models\User;

class PdcFinanceValidationTable extends Component
{
    public $search = '';
    public $statusFilter = '';

    public function render()
    {
        $query = ImprovementProject::where('is_active', true)
            ->with([
                'talent.position',
                'talent.department',
                'talent.promotion_plan.targetPosition',
            ])->whereHas('talent.promotion_plan', function ($q) {
                $q->whereIn('status_promotion', ['Draft', 'In Progress']);
            });

        // Filter: Status (Pending, Approved, Rejected) - Finance mapping
        // We match logic from the Blade where: 
        // finDec is 'Approved' if feedback starts with [Approved]
        // finDec is 'Rejected' if starts with [Rejected]
        // otherwise 'Pending'
        if ($this->statusFilter) {
            if ($this->statusFilter === 'approved') {
                $query->where('finance_feedback', 'like', '[Approved]%');
            } elseif ($this->statusFilter === 'rejected') {
                $query->where('finance_feedback', 'like', '[Rejected]%');
            } elseif ($this->statusFilter === 'pending') {
                $query->whereNull('finance_feedback')
                    ->orWhere(function ($q) {
                        $q->where('finance_feedback', 'not like', '[Approved]%')
                            ->where('finance_feedback', 'not like', '[Rejected]%');
                    });
            }
        }

        // Filter: Search (Talent name or Project title)
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where('title', 'like', $searchTerm)
                ->orWhereHas('talent', fn($qt) => $qt->where('nama', 'like', $searchTerm));
        }

        // Apply sorting manually as original code
        $projects = $query->orderByRaw("FIELD(status, 'Pending', 'Approved', 'Rejected')")
            ->orderBy('created_at', 'desc')
            ->get();

        // Count base values (independent from filters to keep stat card static as original logic,
        // Wait, original logic shows stats of ALL projects. Let's compute overall stats separately)
        $allProjects = ImprovementProject::where('is_active', true)
            ->whereHas('talent.promotion_plan', function ($q) {
                $q->whereIn('status_promotion', ['Draft', 'In Progress']);
            })->get();
        // Here the dashboard wants overall values or filtered values? 
        // Original behavior: The counts are taken from DB before JS filter.
        $total = $allProjects->count();
        $pending = $allProjects->filter(function ($project) {
            return empty($project->finance_feedback) || 
                   (!str_starts_with($project->finance_feedback, '[Approved]') && 
                    !str_starts_with($project->finance_feedback, '[Rejected]'));
        })->count();
        $approved = $allProjects->filter(function ($project) {
            return !empty($project->finance_feedback) && str_starts_with($project->finance_feedback, '[Approved]');
        })->count();
        $rejected = $allProjects->filter(function ($project) {
            return !empty($project->finance_feedback) && str_starts_with($project->finance_feedback, '[Rejected]');
        })->count();

        // Get Finance Users
        $financeUsers = User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))
            ->orderBy('nama')
            ->get();

        return view('livewire.pdc-finance-validation-table', [
            'projects' => $projects,
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'financeUsers' => $financeUsers,
        ]);
    }
}
