<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUserRegistered implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** ID admin PDC penerima notifikasi ini */
    public int $adminId;
    public string $title;
    public string $desc;
    public int $notifId;

    public function __construct(int $adminId, string $title, string $desc, int $notifId)
    {
        $this->adminId = $adminId;
        $this->title = $title;
        $this->desc = $desc;
        $this->notifId = $notifId;
    }

    /**
     * Channel private khusus per-admin PDC (tidak bocor ke user lain).
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('pdc-admin.' . $this->adminId),
        ];
    }

    /**
     * Nama event yang didengar di frontend (window.Echo.channel).
     */
    public function broadcastAs(): string
    {
        return 'notification.new';
    }

    /**
     * Data yang dikirim ke frontend via WebSocket.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notifId,
            'title' => $this->title,
            'desc' => $this->desc,
        ];
    }
}
