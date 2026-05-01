<?php

namespace App\Livewire;

use App\Models\AppNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FinanceNotifikasiList extends Component
{
    public array $notifications = [];
    public int $unreadCount = 0;
    public bool $isEditMode = false;
    public array $selectedNotifications = [];

    private function resolveNotificationTheme(AppNotification $notification): array
    {
        $themes = [
            'success' => [
                'accent' => '#10b981',
                'icon_bg' => '#d1fae5',
                'icon_color' => '#059669',
                'badge_bg' => '#ecfdf5',
                'badge_color' => '#059669',
            ],
            'warning' => [
                'accent' => '#f59e0b',
                'icon_bg' => '#fef3c7',
                'icon_color' => '#d97706',
                'badge_bg' => '#fffbeb',
                'badge_color' => '#d97706',
            ],
            'info' => [
                'accent' => '#3b82f6',
                'icon_bg' => '#dbeafe',
                'icon_color' => '#2563eb',
                'badge_bg' => '#eff6ff',
                'badge_color' => '#1d4ed8',
            ],
        ];

        $defaultTheme = $themes['info'];
        return $themes[$notification->type ?? 'info'] ?? $defaultTheme;
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
            'is_read' => (bool)$n->is_read,
            'time' => $n->created_at->diffForHumans(),
            'accent' => $theme['accent'],
            'icon_bg' => $theme['icon_bg'],
            'icon_color' => $theme['icon_color'],
            'badge_bg' => $theme['badge_bg'],
            'badge_color' => $theme['badge_color'],
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
        $this->isEditMode = !$this->isEditMode;
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
        return view('livewire.finance-notifikasi-list');
    }
}
