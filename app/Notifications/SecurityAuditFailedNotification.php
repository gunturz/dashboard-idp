<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecurityAuditFailedNotification extends Notification
{
    use Queueable;

    private $outputMsg;

    /**
     * Create a new notification instance.
     */
    public function __construct($outputMsg = null)
    {
        $this->outputMsg = $outputMsg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject('CRITICAL: Security Vulnerability Detected!')
            ->greeting('Hello ' . $notifiable->nama . ',')
            ->line('A security vulnerability was found during the automated weekly update and audit.')
            ->line('Details context: ' . ($this->outputMsg ?? 'Composer/NPM Audit failed with non-zero exit code.'))
            ->action('Go to Dashboard', url('/'))
            ->line('Please check the server immediately to resolve these vulnerabilities.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'security_audit_failed',
            'title' => 'Security Vulnerability Detected',
            'message' => 'Automated audit found vulnerabilities. Check the server.',
        ];
    }
}
