<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BatchDeleteCompleted extends Notification
{
    use Queueable;

    private $user;
    private $institutionFrom;
    private $clientId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $institutionFrom, $clientId)
    {
        $this->user = $user;
        $this->institutionFrom = $institutionFrom;
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

        $details['email_title'] = "Batch User Delete Completed";
        $details['email_message'] = "Your batch delete for the ".$this->institutionFrom." institution has completed";

        //get the client custom settings (colours, logo, ...)
        $clientSettings = app('clientService')->getClientSettings($this->clientId);

        return (new MailMessage)->view('admin.mail.batch-user-delete.completed', ['details' => $details, 'clientSettings' => $clientSettings])
                                ->subject("MyDirections - Batch User Delete Completed");

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
