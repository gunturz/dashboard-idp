<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

/**
 * Private channel per PDC Admin.
 * Hanya user yang ID-nya cocok yang boleh subscribe.
 */
Broadcast::channel('pdc-admin.{adminId}', function ($user, $adminId) {
    return (int)$user->id === (int)$adminId;
});
