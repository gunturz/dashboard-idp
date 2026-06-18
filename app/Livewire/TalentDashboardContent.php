<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\IdpActivity;
use App\Models\ImprovementProject;
use App\Models\DevelopmentSession;

class TalentDashboardContent extends Component
{
    use WithFileUploads;

    public $judul_project;
    public $project_file;
    public $editingProjectId = null;
    public $isEditMode = false;

    protected function hasIsActiveColumn(string $table): bool
    {
        return Schema::hasColumn($table, 'is_active');
    }

    protected function hasCompleteDevelopmentPlan($user, ?DevelopmentSession $developmentSession = null): bool
    {
        $plan = $user->promotion_plan;
        $developmentSession ??= DevelopmentSession::where('user_id_talent', $user->id)
            ->where('is_active', true)
            ->latest('created_at')
            ->first();

        $hasTargetPosition = !empty($plan?->target_position_id) || !empty($developmentSession?->target_position_id);
        $hasAtasan = !empty($developmentSession?->atasan_id) || !empty($user->atasan_id);
        $hasMentor = collect($plan?->mentor_ids ?? $developmentSession?->mentor_ids ?? [])
            ->filter()
            ->isNotEmpty() || !empty($user->mentor_id);
        $hasPeriod = !empty($plan?->start_date) && !empty($plan?->target_date);

        return $hasTargetPosition && $hasAtasan && $hasMentor && $hasPeriod;
    }

    protected function incompleteDevelopmentPlanMessage(): string
    {
        return 'Menunggu PDC Admin mendaftarkan Development plan';
    }

    public function editProject($id)
    {
        $user = Auth::user();
        if (optional($user->promotion_plan)->is_locked) {
            session()->flash('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            return;
        }

        $project = ImprovementProject::where('user_id_talent', $user->id)->findOrFail($id);

        // Determine project status
        $projectStatus = 'Pending';
        if (str_starts_with($project->finance_feedback ?? '', '[Approved]')) {
            $projectStatus = 'Approved';
        } elseif (str_starts_with($project->finance_feedback ?? '', '[Rejected]')) {
            $projectStatus = 'Rejected';
        } elseif (in_array($project->status, ['Approved', 'Verified'], true)) {
            $projectStatus = 'Approved';
        } elseif ($project->status === 'Rejected') {
            $projectStatus = 'Rejected';
        }

        if ($projectStatus === 'Approved') {
            session()->flash('error', 'Project yang sudah disetujui tidak dapat diedit.');
            return;
        }

        $this->editingProjectId = $project->id;
        $this->isEditMode = true;
        $this->judul_project = $project->title;
        $this->project_file = null;
        $this->resetErrorBag();

        $this->dispatch('scroll-to-project-form');
    }

    public function cancelEdit()
    {
        $this->reset(['judul_project', 'project_file', 'editingProjectId', 'isEditMode']);
        $this->resetErrorBag();
    }

    public function submitProject()
    {
        $user = Auth::user();
        if (optional($user->promotion_plan)->is_locked) {
            session()->flash('error', 'Progress Anda telah dikunci oleh Admin PDC. Anda tidak dapat mengirim atau mengubah data.');
            return;
        }

        $developmentSession = DevelopmentSession::where('user_id_talent', $user->id)
            ->where('is_active', true)
            ->latest('created_at')
            ->first();

        if (!$developmentSession) {
            session()->flash('error', 'Development plan aktif belum tersedia. Hubungi Admin PDC terlebih dahulu.');
            return;
        }

        if (!$this->hasCompleteDevelopmentPlan($user, $developmentSession)) {
            session()->flash('error', $this->incompleteDevelopmentPlanMessage());
            return;
        }

        if ($this->isEditMode) {
            $this->validate([
                'judul_project' => 'required|string|max:255',
                'project_file' => 'nullable|file|max:10240|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
            ], [
                'judul_project.required' => 'Judul project harus diisi.',
                'project_file.max' => 'Ukuran file tidak boleh melebihi 10 MB.',
                'project_file.mimes' => 'Format file tidak didukung.',
            ]);

            try {
                $project = ImprovementProject::where('user_id_talent', $user->id)->findOrFail($this->editingProjectId);

                $updateData = [
                    'title' => $this->judul_project,
                    'status' => 'Pending',
                    'feedback' => null,
                    'finance_feedback' => null,
                    'verify_by' => null,
                    'verify_at' => null,
                ];

                if ($this->project_file) {
                    $extension = $this->project_file->getClientOriginalExtension();
                    $baseName = Str::slug($this->judul_project) ?: 'project-improvement';
                    $storedFileName = $baseName . '-' . now()->format('Ymd-His') . '.' . $extension;
                    $documentPath = $this->project_file->storeAs('improvement_projects', $storedFileName, 'public');

                    // Delete old file if exists
                    if ($project->document_path) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($project->document_path);
                    }

                    $updateData['document_path'] = $documentPath;
                }

                $project->update($updateData);

                $this->notifyPdcAdmins(
                    'Project Improvement Diperbarui',
                    'Talent <span class="font-semibold">' . e($user->nama) . '</span> telah memperbarui Project Improvement berjudul <span class="font-semibold">' . e($this->judul_project) . '</span>.',
                    'info'
                );

                $updatedJudul = $this->judul_project;
                $this->cancelEdit();
                session()->flash('success_project', 'Anda sudah berhasil memperbarui project improvement dengan judul "' . $updatedJudul . '".');

            } catch (\Exception $e) {
                Log::error('Livewire updateProject error: ' . $e->getMessage());
                session()->flash('error', 'Terjadi kesalahan saat memperbarui project.');
            }
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
            $extension = $this->project_file->getClientOriginalExtension();
            $baseName = Str::slug($this->judul_project) ?: 'project-improvement';
            $storedFileName = $baseName . '-' . now()->format('Ymd-His') . '.' . $extension;
            $documentPath = $this->project_file->storeAs('improvement_projects', $storedFileName, 'public');

            ImprovementProject::create([
                'user_id_talent' => $user->id,
                'development_session_id' => $developmentSession->id,
                'title' => $this->judul_project,
                'document_path' => $documentPath,
                'status' => 'Pending',
            ]);

            $this->notifyPdcAdmins(
                'Project Improvement Baru',
                'Talent <span class="font-semibold">' . e($user->nama) . '</span> telah mengunggah Project Improvement berjudul <span class="font-semibold">' . e($this->judul_project) . '</span>.',
                'info'
            );

            $submittedJudul = $this->judul_project;
            $this->reset(['judul_project', 'project_file']);
            session()->flash('success_project', 'Anda sudah berhasil mensubmit project improvement dengan judul "' . $submittedJudul . '".');

        } catch (\Exception $e) {
            Log::error('Livewire submitProject error: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan project.');
        }
    }

    protected function notifyPdcAdmins($title, $desc, $type = 'info'): void
    {
        $adminIds = \App\Models\User::query()
            ->where(function ($query) {
                $query->whereHas('roles', fn($q) => $q->whereIn('role_name', ['admin', 'pdc admin', 'pdc_admin']))
                    ->orWhereHas('role', fn($q) => $q->whereIn('role_name', ['admin', 'pdc admin', 'pdc_admin']));
            })
            ->pluck('id')
            ->unique()
            ->values()
            ->all();

        foreach (collect($adminIds)->filter()->unique() as $adminId) {
            $notification = \App\Models\AppNotification::create([
                'user_id' => $adminId,
                'title' => $title,
                'desc' => $desc,
                'type' => $type,
                'is_read' => false,
            ]);

            try {
                broadcast(new \App\Events\UserNotificationCreated(
                    (int) $adminId,
                    (int) $notification->id,
                    (string) $title,
                    (string) $desc,
                    (string) $type
                ));
            } catch (\Throwable $e) {
                Log::warning('Broadcast notification failed after project submission: ' . $e->getMessage(), [
                    'admin_id' => $adminId,
                    'notification_id' => $notification->id,
                ]);
            }
        }
    }

    public function render()
    {
        $user = Auth::user();
        $developmentSession = DevelopmentSession::where('user_id_talent', $user->id)
            ->where('is_active', true)
            ->latest('created_at')
            ->first();

        // 1. Kinerja (Kompetensi) Logic
        $hasDevPlan = $this->hasCompleteDevelopmentPlan($user, $developmentSession);
        $developmentPlanIncompleteMessage = $this->incompleteDevelopmentPlanMessage();

        $latestAssessment = DB::table('assessment_session')
            ->where('user_id_talent', $user->id)
            ->when($developmentSession, fn($query) => $query->where('development_session_id', $developmentSession->id))
            ->when(!$developmentSession, fn($query) => $query->whereNull('development_session_id'))
            ->when(
                $this->hasIsActiveColumn('assessment_session'),
                fn($query) => $query->where('is_active', true)
            )
            ->orderBy('created_at', 'desc')
            ->first();

        $hasActiveAssessment = $latestAssessment ? true : false;

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
            ->when($developmentSession, fn($query) => $query->where('development_session_id', $developmentSession->id))
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
            ->when($developmentSession, fn($query) => $query->where('development_session_id', $developmentSession->id))
            ->when(
                $this->hasIsActiveColumn('improvement_project'),
                fn($query) => $query->where('is_active', true)
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.talent-dashboard-content', compact(
            'hasDevPlan',
            'developmentPlanIncompleteMessage',
            'latestAssessment',
            'hasActiveAssessment',
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
