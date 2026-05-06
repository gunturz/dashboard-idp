<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;

class PdcCompanyManagement extends Component
{
    public string $search = '';

    // Modal Add
    public bool $showAddModal = false;
    public string $newCompanyName = '';

    // Modal Edit
    public bool $showEditModal = false;
    public ?int $editingCompanyId = null;
    public string $editingCompanyName = '';

    // Modal Delete
    public bool $showDeleteModal = false;
    public ?int $deletingCompanyId = null;
    public string $deletingCompanyName = '';

    protected $rules = [
        'newCompanyName' => 'required|string|max:255',
        'editingCompanyName' => 'required|string|max:255',
    ];

    public function openAddModal(): void
    {
        $this->newCompanyName = '';
        $this->showAddModal = true;
    }

    public function addCompany(): void
    {
        $this->validate(['newCompanyName' => 'required|string|max:255']);
        Company::create(['nama_company' => $this->newCompanyName]);
        $this->newCompanyName = '';
        $this->showAddModal = false;
        session()->flash('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function openEditModal(int $id, string $name): void
    {
        $this->editingCompanyId = $id;
        $this->editingCompanyName = $name;
        $this->showEditModal = true;
    }

    public function updateCompany(): void
    {
        $this->validate(['editingCompanyName' => 'required|string|max:255']);
        Company::findOrFail($this->editingCompanyId)->update(['nama_company' => $this->editingCompanyName]);
        $this->showEditModal = false;
        session()->flash('success', 'Perusahaan berhasil diperbarui.');
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->deletingCompanyId = $id;
        $this->deletingCompanyName = $name;
        $this->showDeleteModal = true;
    }

    public function deleteCompany(): void
    {
        Company::findOrFail($this->deletingCompanyId)->delete();
        $this->showDeleteModal = false;
        $this->deletingCompanyId = null;
        $this->deletingCompanyName = '';
        session()->flash('success', 'Perusahaan berhasil dihapus.');
    }

    public function render()
    {
        $companies = Company::when($this->search, fn($q) => $q->where('nama_company', 'like', '%' . $this->search . '%'))
            ->orderBy('id')
            ->get();

        return view('livewire.pdc-company-management', compact('companies'));
    }
}
