<?php
# app/routes/console.php
# php artisan send-mail

use Illuminate\Support\Facades\Artisan;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

Artisan::command('send-mail', function () {
    $email = (new MailtrapEmail())
        ->from(new Address('hello@demomailtrap.co', 'Mailtrap Test'))
        ->to(new Address('prasetyoguntur045@gmail.com'))
        ->subject('You are awesome!')
        ->category('Integration Test')
        ->text('Congrats for sending test email with Mailtrap!')
    ;

    $response = MailtrapClient::initSendingEmails(
        apiKey: '<YOUR_API_TOKEN>'
    )->send($email);

    
    // Audit dependency setiap Senin jam 07:00
    Schedule::command('security:dependency-audit --notify')
        ->weeklyOn(1, '07:00')
        ->withoutOverlapping()
        ->onFailure(function () {
            Log::channel('security')->critical('Dependency audit schedule gagal dijalankan!');
        });


    var_dump(ResponseHelper::toArray($response));
})->purpose('Send Mail');