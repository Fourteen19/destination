<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminRequestEventAction extends Mailable
{
    use Queueable, SerializesModels;

    public $details;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //get the client custom settings (colours, logo, ...)
        $clientSettings = app('clientService')->getClientSettings(Auth::guard('admin')->user()->client_id);

        return $this->subject('Mail from '.Auth::guard('admin')->user()->TitleFullName.' - Regarding Event: '.$this->details['title'])->view('admin.mail.admin-requests-event-action', ['clientSettings' => $clientSettings]);
    }

}
