<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ImprovementProject;
use App\Models\User;
use App\Models\Company;
use App\Models\AppNotification;
use App\Events\UserNotificationCreated;

class PdcFinanceValidationTable extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $companyFilter = '';

    // Delete modal state
    public $showDeleteModal = false;
    public $deletingProjectId = null;
    public $deletingProjectTitle = '';
    public $deletingTalentName = '';

    public function openDeleteModal($projectId, $projectTitle, $talentName)
    {
        $this->deletingProjectId = $projectId;
        $this->deletingProjectTitle = $projectTitle;
        $this->deletingTalentName = $talentName;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        $project = ImprovementProject::find($this->deletingProjectId);
        if ($project) {
            $talentId = $project->user_id_talent;
            $projectTitle = $project->title;

            $project->update(['is_active' => false]);

            // Create and broadcast notification to talent
            if ($talentId) {
                $notification = AppNotification::create([
                    'user_id' => $talentId,
                    'title'   => 'Project Improvement Dihapus',
                    'desc'    => 'Project Improvement Anda yang berjudul <span class="font-semibold">' . e($projectTitle) . '</span> telah dihapus oleh Admin PDC.',
                    'type'    => 'danger',
                    'is_read' => false,
                ]);

                try {
                    broadcast(new UserNotificationCreated(
                        (int) $talentId,
                        (int) $notification->id,
                        (string) 'Project Improvement Dihapus',
                        (string) 'Project Improvement Anda yang berjudul <span class="font-semibold">' . e($projectTitle) . '</span> telah dihapus oleh Admin PDC.',
                        (string) 'danger'
                    ));
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Broadcast notification to talent failed after project deletion: ' . $e->getMessage());
                }
            }

            session()->flash('success', 'Project "' . $this->deletingProjectTitle . '" berhasil dihapus.');
        }
        $this->showDeleteModal = false;
        $this->deletingProjectId = null;
        $this->deletingProjectTitle = '';
        $this->deletingTalentName = '';
    }

    public function render()
    {
        $query = ImprovementProject::where('is_active', true)
            ->with([
                'talent.position',
                'talent.department',
                'talent.company',
                'talent.promotion_plan.targetPosition',
            ])->whereHas('talent.promotion_plan', function ($q) {
                $q->whereNotIn('status_promotion', ['Promoted', 'Not Promoted']);
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

        // Filter: Company
        if ($this->companyFilter) {
            $query->whereHas('talent', function ($q) {
                $q->where('company_id', $this->companyFilter);
            });
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

        // Count base values (independent from filters to keep stat card static)
        $allProjects = ImprovementProject::where('is_active', true)
            ->whereHas('talent.promotion_plan', function ($q) {
                $q->whereNotIn('status_promotion', ['Promoted', 'Not Promoted']);
            })->get();

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

        // Get all Companies for filter dropdown
        $companies = Company::orderBy('nama_company')->get();

        return view('livewire.pdc-finance-validation-table', [
            'projects'     => $projects,
            'total'        => $total,
            'pending'      => $pending,
            'approved'     => $approved,
            'rejected'     => $rejected,
            'financeUsers' => $financeUsers,
            'companies'    => $companies,
        ]);
    }
}
