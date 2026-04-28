<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\IdpActivity;
use App\Models\ImprovementProject;

class TalentDashboardContent extends Component
{
    use WithFileUploads;

    public $judul_project;
    public $project_file;

    protected function hasIsActiveColumn(string $table): bool
    {
        return Schema::hasColumn($table, 'is_active');
    }

    public function submitProject()
    {
        $user = Auth::user();
        if (optional($user->promotion_plan)->is_locked) {
            session()->flash('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            return;
        }

        $this->validate([
            'judul_project' => 'required|string|max:255',
            'project_file' => 'required|file|max:10240|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
        ], [
            'judul_project.required' => 'Judul project harus diisi.',
            'project_file.required' => 'File project harus diunggah.',
            'project_file.max' => 'Ukuran file tidak boleh melebihi 10 MB.',
            'project_file.mimes' => 'Format file tidak didukung.',
        ]);

        try {
            $documentPath = $this->project_file->store('improvement_projects', 'public');

            ImprovementProject::create([
                'user_id_talent' => $user->id,
                'title' => $this->judul_project,
                'document_path' => $documentPath,
                'status' => 'Pending',
            ]);

            // Notification omitted here as it requires Controller base methods, 
            // but we can add directly via Notification model if configured.
            // For simplicity we just flash success.
            $this->reset(['judul_project', 'project_file']);
            session()->flash('success_project', 'Project Improvement berhasil disubmit.');

        }
        catch (\Exception $e) {
            Log::error('Livewire submitProject error: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan project.');
        }
    }

    public function render()
    {
        $user = Auth::user();

        // 1. Kinerja (Kompetensi) Logic
        $hasDevPlan = !is_null(optional($user->promotion_plan)->target_position_id);

        $latestAssessment = DB::table('assessment_session')
            ->where('user_id_talent', $user->id)
            ->when(
                $this->hasIsActiveColumn('assessment_session'),
                fn($query) => $query->where('is_active', true)
            )
            ->orderBy('created_at', 'desc')
            ->first();

        $kompetensiData = [];
        $atasanHasScored = false;

        if ($latestAssessment) {
            $details = DB::table('detail_assessment')
                ->join('competencies', 'detail_assessment.competence_id', '=', 'competencies.id')
                ->where('assessment_id', $latestAssessment->id)
                ->select('competencies.name', 'detail_assessment.score_talent', 'detail_assessment.score_atasan', 'detail_assessment.gap_score')
                ->get();

            $totalAtasanScore = $details->sum('score_atasan');
            if ($totalAtasanScore > 0) {
                $atasanHasScored = true;
            }

            foreach ($details as $d) {
                $avg = min(5, ($d->score_talent + $d->score_atasan) / 2);
                $kompetensiData[$d->name] = [
                    'score' => $avg,
                    'gap' => $d->gap_score ?? 0
                ];
            }
        }

        // 2. IDP Charts
        $idpActivities = IdpActivity::with('type')
            ->where('user_id_talent', $user->id)
            ->when(
                $this->hasIsActiveColumn('idp_activity'),
                fn($query) => $query->where('is_active', true)
            )
            ->get();

        $exposureCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Exposure')->count();
        $learningCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Learning')->count();
        $mentoringCount = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Mentoring')->count();

        // 3. Projects
        $projects = ImprovementProject::where('user_id_talent', $user->id)
            ->when(
                $this->hasIsActiveColumn('improvement_project'),
                fn($query) => $query->where('is_active', true)
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.talent-dashboard-content', compact(
            'hasDevPlan',
            'latestAssessment',
            'atasanHasScored',
            'kompetensiData',
            'exposureCount',
            'learningCount',
            'mentoringCount',
            'projects',
            'user'
        ));
    }
}
