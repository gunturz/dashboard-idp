<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotificationCreated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $userId,
        public int $notificationId,
        public string $title,
        public string $desc,
        public string $type = 'info',
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user-notifications.' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notificationId,
            'title' => $this->title,
            'desc' => $this->desc,
            'type' => $this->type,
            'created_at' => now()->toIso8601String(),
        ];
    }
}
