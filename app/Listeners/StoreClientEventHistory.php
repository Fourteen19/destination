<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\ClientEventHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreClientEventHistory implements ShouldQueue
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
    public function handle(ClientEventHistory $event)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();
        //dd($event->id);
        $eventInfo = $event->event;

        $saveHistory = DB::table('events_access')->insert(
            ['client_id' => $event->clientId,
             'event_id' => $eventInfo->id,
             'year_id' => app('currentYear'),
             'created_at' => $current_timestamp,
             'updated_at' => $current_timestamp]
        );

        return $saveHistory;
    }
}
