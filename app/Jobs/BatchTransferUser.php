<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ThrowUpException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Validation\ValidationException;

class BatchTransferUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $transferTo;
    protected $transferFrom;
    protected $adminEmail;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($adminEmail, $users, $transferFrom, $transferTo)
    {
        $this->adminEmail = $adminEmail;
        $this->users = $users;
        $this->transferFrom = $transferFrom;
        $this->transferTo = $transferTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        DB::beginTransaction();

        try {

            $transferTo = $this->transferTo;
            $transferFrom = $this->transferFrom;

            DB::table('users')->wherein('uuid', $this->users)
                ->lazyById()->each(function ($user) use ($transferTo, $transferFrom) {
                    DB::table('users')
                        ->where('institution_id', $transferFrom)
                        ->where('id', $user->id)
                        ->update(['institution_id' => $transferTo]);
                });

            DB::commit();
            // all good

        } catch (\Exception $e) {

            DB::rollback();
            // something went wrong
        }


    }



    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable  $e)
    {

        $adminEmail = $this->adminEmail;

        $details['email_message'] =  "An error occured while transfering users to another institution";
        $details['email_title'] = "MyDirections - Batch Transfer";

        Mail::send('admin.mail.simple-layout', ['details' => $details], function ($message) use ($adminEmail)
        {
            $message->from('no-reply@mydirections.co.uk', 'mydirections.co.uk');
            $message->to($adminEmail);
            $message->subject("Mydirections - Batch Transfer");
        });


        $adminEmail = "fred@rfmedia.co.uk";

        $details['email_message'] =  "An error occured while transfering users to another institution";
        $details['email_title'] = "MyDirections - Batch Transfer";

        Mail::send('admin.mail.email-to-rfmedia', ['details' => $details], function ($message) use ($adminEmail)
        {
            $message->from('no-reply@mydirections.co.uk', 'mydirections.co.uk');
            $message->to($adminEmail);
            $message->subject("Mydirections - Batch Transfer");
        });
    }


}
