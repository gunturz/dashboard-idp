<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordLinkNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $resetUrl
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Password Akun IDP Anda')
            ->greeting('Halo '.$notifiable->nama.',')
            ->line('Kami menerima permintaan untuk mereset password akun Anda.')
            ->action('Reset Password', $this->resetUrl)
            ->line('Link ini berlaku selama 60 menit dan hanya dapat digunakan satu kali.')
            ->line('Jika Anda tidak merasa meminta reset password, abaikan email ini.');
    }
}
