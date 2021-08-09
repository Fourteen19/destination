<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\LoginHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreUserLoginHistory implements ShouldQueue
{

    use InteractsWithQueue;

    public $afterCommit = true;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'default';


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginHistory  $event
     * @return void
     */
    public function handle(LoginHistory $event)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $userinfo = $event->user;


        $saveHistory = False;



        DB::beginTransaction();

        try {

            $saveHistory = DB::table('login_access')->insert(
                ['client_id' => $userinfo->client_id,
                'user_id' => $userinfo->id,
                'institution_id' => $userinfo->institution_id,
                'year_id' => app('currentYear'),
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp]
            );

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

        }

        return $saveHistory;
    }
}
