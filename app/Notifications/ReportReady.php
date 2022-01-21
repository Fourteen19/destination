<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReportReady extends Notification
{
    use Queueable;

    private $filename;
    private $clientId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($filename, $clientId)
    {
        $this->filename = $filename;
        $this->clientId = $clientId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        //get the client custom settings (colours, logo, ...)
        $clientSettings = app('clientService')->getClientSettings($this->clientId);

        $mailData['email_title'] = "Your report is ready!";

        return (new MailMessage)->view('admin.mail.reports.report_ready', ['details' => $mailData, 'clientSettings' => $clientSettings])
                                ->subject("Your report is ready!")
                                ->attach( storage_path("app/exports/".$this->filename) );

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
