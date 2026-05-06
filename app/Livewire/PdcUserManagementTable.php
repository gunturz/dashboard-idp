<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class PdcUserManagementTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $company = '';
    public string $department = '';
    public string $selectedRole = '';

    public function updatingSearch(): void
    {
        $this->resetAllPages();
    }

    public function updatingCompany(): void
    {
        $this->department = '';
        $this->resetAllPages();
    }

    public function updatingDepartment(): void
    {
        $this->resetAllPages();
    }

    public function toggleRole(string $role): void
    {
        if ($this->selectedRole === $role) {
            $this->selectedRole = '';
        } else {
            $this->selectedRole = $role;
        }
        $this->resetAllPages();
    }

    private function resetAllPages(): void
    {
        $roles = ['talent', 'mentor', 'atasan', 'finance', 'panelis'];
        foreach ($roles as $r) {
            $this->resetPage("page_{$r}");
        }
    }

    private function usersForRole(string $roleName)
    {
        return User::with(['company', 'department', 'position', 'roles'])
            ->whereHas('roles', fn($q) => $q->where('role_name', $roleName))
            ->when($this->search, fn($q) => $q->where('nama', 'like', "%{$this->search}%"))
            ->when($this->company, fn($q) => $q->where('company_id', $this->company))
            ->when($this->department, fn($q) => $q->whereHas(
                'department',
                fn($q2) => $q2->where('nama_department', 'like', "%{$this->department}%")
            ))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(7, ['*'], "page_{$roleName}");
    }

    public function render()
    {
        $roleList = ['talent', 'mentor', 'atasan', 'finance', 'panelis'];

        // Counts (unfiltered by search/dept/company, simply total per role)
        $counts = [];
        foreach ($roleList as $r) {
            $counts[ucfirst($r)] = User::whereHas('roles', fn($q) => $q->where('role_name', $r))->count();
        }

        // Users grouped by role (filtered by selectedRole and global filters)
        $usersByRole = [];
        if ($this->selectedRole) {
            $usersByRole[$this->selectedRole] = $this->usersForRole($this->selectedRole);
        } else {
            foreach ($roleList as $r) {
                $usersByRole[$r] = $this->usersForRole($r);
            }
        }

        $companies = Company::orderBy('id')->get();

        // Departments diload jika company terpilih
        $departments = collect();
        if ($this->company) {
            $departments = Department::orderBy('nama_department')
                ->where('company_id', $this->company)
                ->get();
        }

        return view('livewire.pdc-user-management-table', [
            'usersByRole' => $usersByRole,
            'counts' => $counts,
            'companies' => $companies,
            'departments' => $departments,
        ]);
    }
}
