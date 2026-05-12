<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SecurityAuditFailedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotifyAuditFailed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:notify-audit-failed {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to PDC Admin when audit fails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all users who are PDC Admins
        $admins = User::with('roles')->get()->filter(function ($user) {
            return $user->hasRole(['pdc_admin', 'admin', 'pdc admin', 'admin.pdc']);
        });

        if ($admins->isEmpty()) {
            $this->error('No PDC Admins found to notify.');
            return;
        }

        $message = $this->option('message');

        Notification::send($admins, new SecurityAuditFailedNotification($message));

        $this->info('Audit failure notification sent to PDC Admins.');
    }
}
