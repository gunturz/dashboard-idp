<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\IdpActivity;
use Illuminate\Support\Facades\Auth;

class TalentLogbookTable extends Component
{
    public $activeTab = 'exposure';

    public function mount()
    {
    // Default we start with exposure
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public bool $showDeleteModal = false;
    public ?int $deletingLogbookId = null;

    public function openDeleteModal($id)
    {
        $this->deletingLogbookId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteLogbook()
    {
        if ($this->deletingLogbookId) {
            IdpActivity::findOrFail($this->deletingLogbookId)->delete();
            $this->showDeleteModal = false;
            $this->deletingLogbookId = null;
            session()->flash('success', 'Aktivitas berhasil dihapus.');
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Get activities for current tab only to save memory
        // Capitalize the first letter since DB has 'Exposure', 'Mentoring', 'Learning'
        $tabName = ucfirst($this->activeTab);

        $activities = IdpActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $user->id)
            ->whereHas('type', function ($q) use ($tabName) {
            $q->where('type_name', $tabName);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [];
        foreach ($activities as $act) {
            $docPaths = [];
            $docNames = [];
            if ($act->document_path) {
                if (str_starts_with($act->document_path, '["')) {
                    $docPaths = json_decode($act->document_path, true) ?? [];
                    $docNames = $act->file_name ? explode(', ', $act->file_name) : [];
                }
                else {
                    $docPaths = [$act->document_path];
                    $docNames = [$act->file_name ?? ''];
                }
            }

            $data[] = [
                'id' => $act->id,
                'mentor' => $act->verifier ? $act->verifier->nama : '-',
                'sumber' => $act->activity, // for Learning
                'tema' => $act->theme,
                'tanggal_update' => $act->updated_at,
                'tanggal' => $act->activity_date,
                'lokasi' => $act->location,
                'aktivitas' => $act->activity, // for Exposure
                'deskripsi' => $act->description,
                'action_plan' => $act->action_plan,
                'platform' => $act->platform, // for Learning
                'file_paths' => $docPaths,
                'file_names' => $docNames,
                'status' => $act->status,
            ];
        }

        return view('livewire.talent-logbook-table', [
            'data' => $data,
            'user' => $user
        ]);
    }
}
