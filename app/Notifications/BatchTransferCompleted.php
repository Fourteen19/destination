<?php

namespace App\Notifications;

use App\Models\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BatchTransferCompleted extends Notification
{
    use Queueable;

    private $user;
    private $nbUser;
    private $institutionFrom;
    private $institutionTo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Admin $user, $nbUser, $institutionFrom, $institutionTo)
    {
        $this->user = $user;
        $this->nbUser = $nbUser;
        $this->institutionFrom = $institutionFrom;
        $this->institutionTo = $institutionTo;
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
        $details['email_title'] = "Batch User Tansfer Completed";
        $details['email_message'] = "Your batch transfer of ".$this->nbUser." ".Str::plural('user', $this->nbUser)." from ".$this->institutionFrom." to ".$this->institutionTo." is complete";

        return (new MailMessage)->view('admin.mail.batch-user-transfer.completed', ['details' => $details])
                                ->subject("MyDirections - Batch User Tansfer Completed");

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
