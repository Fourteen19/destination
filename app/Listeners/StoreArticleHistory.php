<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\ContentAccess;
use App\Events\ArticleHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreArticleHistory implements ShouldQueue
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
    public function handle(ArticleHistory $event)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $userInfo = $event->user;
        $articleInfo = $event->article;

        $saveHistory = False;


        DB::beginTransaction();

        try {

            $model = DB::table('content_access')->insert(
                ['client_id' => $userInfo->client_id,
                'institution_id' => $userInfo->institution_id,
                'content_id' => $articleInfo->id,
                'user_id' => $userInfo->id,
                'year_id' => app('currentYear'),
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp]
            );

            DB::commit();

            if ($model instanceof ContentAccess) {

                $saveHistory = True;

            } else {

                $saveHistory = False;
            }

        } catch (\Exception $e) {

            DB::rollback();

        }


        return $saveHistory;
    }
}
