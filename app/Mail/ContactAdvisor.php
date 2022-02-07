<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactAdvisor extends Mailable
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
        //only allow the br tag in the email
        $details['questionText'] = strip_tags($details['questionText'], '<br>');

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
        $clientSettings = app('clientService')->getClientSettings($this->details['client_id']);

        return $this->subject('Mail from '.$this->details['full_name'].' - Regarding: '.$this->details['questionType'])->view('frontend.emails.contact-my-advisor', ['clientSettings' => $clientSettings]);
    }
}
