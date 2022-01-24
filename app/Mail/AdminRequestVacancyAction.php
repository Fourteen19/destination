<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminRequestVacancyAction extends Mailable
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
        if ( adminHasAnyRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Employer')]) )
        {
            $employerName = ' at '.UCWords(Auth::guard('admin')->user()->employer->name);
        } else {
            $employerName = '';
        }

        //get the client custom settings (colours, logo, ...)
        $clientSettings = app('clientService')->getClientSettings(Auth::guard('admin')->user()->client_id);

        return $this->subject('Mail from '.Auth::guard('admin')->user()->TitleFullName.$employerName.' - Regarding Vacancy: '.$this->details['title'])->view('admin.mail.admin-requests-vacancy-action', ['clientSettings' => $clientSettings]);
    }

}
