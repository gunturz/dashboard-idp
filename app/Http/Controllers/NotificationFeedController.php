<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationFeedController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        abort_unless($userId, 401);

        $latestNotification = AppNotification::where('user_id', $userId)
            ->latest('created_at')
            ->latest('id')
            ->first();

        $unreadCount = AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()
            ->json([
                'latest' => $latestNotification
                    ? [
                        'id' => $latestNotification->id,
                        'title' => $latestNotification->title,
                        'desc' => $latestNotification->desc,
                        'time' => $latestNotification->created_at?->diffForHumans(),
                        'is_read' => (bool) $latestNotification->is_read,
                    ]
                    : null,
                'unread_count' => $unreadCount,
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
