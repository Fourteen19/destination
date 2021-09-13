<?php

namespace App\Jobs\Frontend;

use App\Mail\ContactAdvisor;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailToAdvisor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $sendTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $sendTo)
    {
        $this->data = $data;
        $this->sendTo = $sendTo;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->sendTo)->send( new ContactAdvisor($this->data) );
    }
}
