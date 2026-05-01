<?php

namespace App\Livewire;

use App\Models\AppNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PanelisNotifikasiList extends Component
{
    public array $notifications = [];
    public int $unreadCount = 0;
    public bool $isEditMode = false;
    public array $selectedNotifications = [];

    private function resolveNotificationTheme(AppNotification $notification): array
    {
        $themes = [
            'registration-talent' => [
                'accent' => '#2ec4b6',
                'icon_bg' => '#dff6f3',
                'icon_color' => '#2ec4b6',
                'badge_bg' => '#e6fffb',
                'badge_color' => '#0f766e',
            ],
            'registration-mentor' => [
                'accent' => '#60a5fa',
                'icon_bg' => '#e0ecff',
                'icon_color' => '#60a5fa',
                'badge_bg' => '#eff6ff',
                'badge_color' => '#2563eb',
            ],
            'registration-atasan' => [
                'accent' => '#a78bfa',
                'icon_bg' => '#efe7ff',
                'icon_color' => '#8b5cf6',
                'badge_bg' => '#f5f3ff',
                'badge_color' => '#7c3aed',
            ],
            'registration-finance' => [
                'accent' => '#34d399',
                'icon_bg' => '#ddfbf1',
                'icon_color' => '#10b981',
                'badge_bg' => '#ecfdf5',
                'badge_color' => '#059669',
            ],
            'registration-panelis' => [
                'accent' => '#fbbf24',
                'icon_bg' => '#fff4da',
                'icon_color' => '#f59e0b',
                'badge_bg' => '#fffbeb',
                'badge_color' => '#d97706',
            ],
        ];

        $defaultTheme = [
            'accent' => '#3b82f6',
            'icon_bg' => '#dbeafe',
            'icon_color' => '#2563eb',
            'badge_bg' => '#eff6ff',
            'badge_color' => '#1d4ed8',
        ];

        $theme = $themes[$notification->type ?? ''] ?? $defaultTheme;
        $theme['uses_people_icon'] = str_starts_with((string) $notification->type, 'registration-');

        return $theme;
    }

    public function mount(): void
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $items = AppNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $this->notifications = $items->map(function ($n) {
            $theme = $this->resolveNotificationTheme($n);

            return [
                'id' => $n->id,
                'title' => $n->title,
                'desc' => $n->desc,
                'type' => $n->type ?? 'info',
                'badge' => null,
                'is_read' => (bool) $n->is_read,
                'time' => $n->created_at->diffForHumans(),
                'accent' => $theme['accent'],
                'icon_bg' => $theme['icon_bg'],
                'icon_color' => $theme['icon_color'],
                'badge_bg' => $theme['badge_bg'],
                'badge_color' => $theme['badge_color'],
                'uses_people_icon' => $theme['uses_people_icon'],
            ];
        })->toArray();

        $this->unreadCount = collect($this->notifications)
            ->where('is_read', 0)
            ->count();
    }

    public function markAllRead(): void
    {
        AppNotification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $this->loadNotifications();
        $this->dispatch('notifikasi-marked-read');
    }

    public function toggleEditMode(): void
    {
        $this->isEditMode = ! $this->isEditMode;
        $this->selectedNotifications = [];
    }

    public function selectAll(): void
    {
        $this->selectedNotifications = array_column($this->notifications, 'id');
    }

    public function deleteSelected(): void
    {
        if (!empty($this->selectedNotifications)) {
            AppNotification::where('user_id', Auth::id())
                ->whereIn('id', $this->selectedNotifications)
                ->delete();
        }

        $this->isEditMode = false;
        $this->selectedNotifications = [];
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.panelis-notifikasi-list');
    }
}
