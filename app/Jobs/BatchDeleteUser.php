<?php

namespace App\Jobs;

use Throwable;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class BatchDeleteUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $From;
    protected $adminEmail;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($adminEmail, $users, $From)
    {

        $this->From = $From;
        $this->adminEmail = $adminEmail;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        ini_set('max_execution_time', '0');

        DB::beginTransaction();

        try {

            User::wherein('uuid', $this->users)
                ->chunk(50, function ($users) {
                    foreach ($users as $user) {

                        //removes all login access
                        $user->searchedKeywordsName()->detach();

                        //deletes user's activities answers (pivot table)
                        $user->allActivityAnswers()->detach();

                        //deletes user's activities (pivot table)
                        $user->userActivities()->detach();

                        //deletes user's self-assessments
                        $user->selfAssessment()->forceDelete();

                        //deletes user's dashboard
                        $user->dashboard()->forceDelete();

                        //delete articles relationships related to the user (pivot table)
                        $user->articles()->detach();

                        $user->forceDelete();

                    }
                });

            DB::commit();
            // all good

        } catch (\Exception $e) {

            Log::error($e);

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
    public function failed(Throwable $exception)
    {

        $adminEmail = $this->adminEmail;

        $details['email_message'] =  "An error occured while deleting your users";
        $details['email_title'] = "MyDirections - Batch delete";

        Mail::send('admin.mail.simple-layout', ['details' => $details], function ($message) use ($adminEmail)
        {
            $message->from('no-reply@mydirections.co.uk', 'mydirections.co.uk');
            $message->to($adminEmail);
            $message->subject("Mydirections - Batch delete");
        });



        $adminEmail = "fred@rfmedia.co.uk";

        $details['email_message'] =  "An error occured while deleting users. Please review logs.";
        $details['email_title'] = "MyDirections - Batch delete";

        Mail::send('admin.mail.email-to-rfmedia', ['details' => $details], function ($message) use ($adminEmail)
        {
            $message->from('no-reply@mydirections.co.uk', 'mydirections.co.uk');
            $message->to($adminEmail);
            $message->subject("Mydirections - Batch delete");
        });

    }


}
