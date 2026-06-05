<?php

namespace App\Livewire;

use App\Events\UserNotificationCreated;
use App\Models\AppNotification;
use Livewire\Component;
use App\Models\IdpActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TalentLogbookTable extends Component
{
    public $activeTab = 'exposure';
    public $sessionId = null;

    public function mount($activeTab = 'exposure', $sessionId = null)
    {
        $this->sessionId = $sessionId;
        if (in_array($activeTab, ['exposure', 'mentoring', 'learning'], true)) {
            $this->activeTab = $activeTab;
        }
    }

    protected function hasIsActiveColumn(string $table): bool
    {
        return \Illuminate\Support\Facades\Schema::hasColumn($table, 'is_active');
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

    protected function addNotificationToUser($userId, $title, $desc, $type = 'success'): void
    {
        $notification = AppNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'desc' => $desc,
            'type' => $type,
            'is_read' => false,
        ]);

        broadcast(new UserNotificationCreated(
            (int) $userId,
            (int) $notification->id,
            (string) $title,
            (string) $desc,
            (string) $type,
        ));
    }

    protected function addNotificationToUsers(iterable $userIds, $title, $desc, $type = 'success'): void
    {
        foreach (collect($userIds)->filter()->unique() as $userId) {
            $this->addNotificationToUser($userId, $title, $desc, $type);
        }
    }

    protected function resolveMentorNotificationRecipients(User $user, ?int $verifyById = null): array
    {
        $mentorIds = collect(optional($user->promotion_plan)->mentor_ids ?? [])
            ->merge([$user->mentor_id, $verifyById])
            ->filter()
            ->unique()
            ->values();

        return User::query()
            ->whereIn('id', $mentorIds)
            ->whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))
            ->pluck('id')
            ->all();
    }

    protected function getPdcAdminRecipientIds(): array
    {
        return User::query()
            ->where(function ($query) {
                $query->whereHas('roles', fn($q) => $q->whereIn('role_name', ['admin', 'pdc admin', 'pdc_admin']))
                    ->orWhereHas('role', fn($q) => $q->whereIn('role_name', ['admin', 'pdc admin', 'pdc_admin']));
            })
            ->pluck('id')
            ->unique()
            ->values()
            ->all();
    }

    public function deleteLogbook()
    {
        if ($this->deletingLogbookId) {
            $user = Auth::user()->load('promotion_plan');
            $activity = IdpActivity::with('type')->findOrFail($this->deletingLogbookId);

            if ($activity->user_id_talent !== $user->id) {
                abort(403, 'Unauthorized action.');
            }

            $activityType = strtolower($activity->type->type_name ?? 'exposure');
            $activityTheme = $activity->theme ?? '-';
            $verifyById = $activity->verify_by;

            $activity->delete();

            $mentorRecipientIds = $this->resolveMentorNotificationRecipients($user, $verifyById);
            $this->addNotificationToUsers(
                $mentorRecipientIds,
                'IDP Activity Dihapus',
                $user->nama . ' telah menghapus IDP Monitoring (<span class="font-semibold">' . ucfirst($activityType) . '</span>) dengan tema <span class="font-semibold">' . e($activityTheme) . '</span>.',
                'warning'
            );

            $this->addNotificationToUsers(
                $this->getPdcAdminRecipientIds(),
                'IDP Activity Dihapus',
                'Talent <span class="font-semibold">' . e($user->nama) . '</span> telah menghapus aktivitas IDP Monitoring <span class="font-semibold">' . e(ucfirst($activityType)) . '</span> dengan tema <span class="font-semibold">' . e($activityTheme) . '</span>.',
                'warning'
            );

            $this->showDeleteModal = false;
            $this->deletingLogbookId = null;
            session()->flash('success', 'Aktivitas berhasil dihapus.');
        }
    }

    public function render()
    {
        $user = Auth::user()->load('promotion_plan');

        $plan = $user->promotion_plan;

        // Determine if the talent's training period is over:
        // True if no active plan exists (e.g. already archived), OR if it's locked, OR if it's in a final state
        $trainingDone = !$plan
            || $plan->is_locked
            || in_array(
                $plan->status_promotion,
                ['Approved Panelis', 'Promoted', 'Not Promoted']
            );

        // Get activities for current tab only to save memory
        // Capitalize the first letter since DB has 'Exposure', 'Mentoring', 'Learning'
        $tabName = ucfirst($this->activeTab);

        $activities = IdpActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $user->id)
            ->whereHas('type', function ($q) use ($tabName) {
                $q->where('type_name', $tabName);
            })
            ->when($this->sessionId, function ($query) {
                return $query->where('development_session_id', $this->sessionId);
            })
            ->when(!$this->sessionId && $this->hasIsActiveColumn('idp_activity'), function ($query) {
                return $query->where('is_active', true);
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
                } else {
                    $docPaths = [$act->document_path];
                    $docNames = [$act->file_name ?? ''];
                }
            }

            $data[] = [
                'id' => $act->id,
                'mentor' => $act->verifier ? $act->verifier->nama : '-',
                'sumber' => $act->activity,       // for Learning
                'tema' => $act->theme,
                'tanggal_update' => $act->updated_at,
                'tanggal' => $act->activity_date,
                'lokasi' => $act->location,
                'aktivitas' => $act->activity,       // for Exposure
                'deskripsi' => $act->description,
                'action_plan' => $act->action_plan,
                'platform' => $act->platform,       // for Learning
                'file_paths' => $docPaths,
                'file_names' => $docNames,
                'status' => $act->status,
            ];
        }

        return view('livewire.talent-logbook-table', [
            'data' => $data,
            'user' => $user,
            'trainingDone' => $trainingDone,
        ]);
    }
}
