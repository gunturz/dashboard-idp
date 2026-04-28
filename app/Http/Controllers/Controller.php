<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Get unread or all notifications for the current user.
     */
    protected function getNotifications()
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return collect();
        }

        $rawNotifs = \App\Models\AppNotification::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return $rawNotifs->map(function ($n) {
            return [
                'id'      => $n->id,
                'title'   => $n->title,
                'desc'    => $n->desc,
                'type'    => $n->type,
                'time'    => $n->created_at->diffForHumans(),
                'is_read' => $n->is_read,
                'badge'   => $n->is_read ? null : 'Baru',
            ];
        });
    }

    /**
     * Create a notification for a specific user.
     */
    protected function addNotificationToUser($userId, $title, $desc, $type = 'success')
    {
        \App\Models\AppNotification::create([
            'user_id' => $userId,
            'title'   => $title,
            'desc'    => $desc,
            'type'    => $type,
            'is_read' => false,
        ]);
    }

    /**
     * Create the same notification for multiple users.
     */
    protected function addNotificationToUsers(iterable $userIds, $title, $desc, $type = 'success'): void
    {
        foreach (collect($userIds)->filter()->unique() as $userId) {
            $this->addNotificationToUser($userId, $title, $desc, $type);
        }
    }

    /**
     * Get all users that should receive PDC Admin notifications.
     */
    protected function getPdcAdminRecipientIds(): array
    {
        return \App\Models\User::query()
            ->where(function ($query) {
                $query->whereHas('roles', fn($q) => $q->whereIn('role_name', ['admin', 'pdc admin', 'pdc_admin']))
                    ->orWhereHas('role', fn($q) => $q->whereIn('role_name', ['admin', 'pdc admin', 'pdc_admin']));
            })
            ->pluck('id')
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Send the same notification to all PDC Admin recipients.
     */
    protected function notifyPdcAdmins($title, $desc, $type = 'info'): void
    {
        $this->addNotificationToUsers(
            $this->getPdcAdminRecipientIds(),
            $title,
            $desc,
            $type
        );
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllNotificationsRead(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            \App\Models\AppNotification::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
        return back();
    }
}
