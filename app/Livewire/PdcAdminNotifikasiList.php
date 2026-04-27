<?php

namespace App\Livewire;

use App\Models\AppNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PdcAdminNotifikasiList extends Component
{
    public array $notifications = [];
    public int $unreadCount = 0;

    /**
     * Load notifikasi dari database saat komponen dimount.
     */
    public function mount(): void
    {
        $this->loadNotifications();
    }

    /**
     * Memuat ulang data notifikasi dari database.
     * Dipanggil oleh wire:poll dan juga bisa dipanggil dari event.
     */
    public function loadNotifications(): void
    {
        $items = AppNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $this->notifications = $items->map(fn($n) => [
        'id' => $n->id,
        'title' => $n->title,
        'desc' => $n->desc,
        'type' => $n->type ?? 'info',
        'badge' => null,
        'is_read' => (bool)$n->is_read,
        'time' => $n->created_at->diffForHumans(),
        ])->toArray();

        $this->unreadCount = collect($this->notifications)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllRead(): void
    {
        AppNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.pdc-admin-notifikasi-list');
    }
}
