<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\ArticleHistory;
use Illuminate\Support\Facades\DB;
use App\Models\ArticlesMonthlyStats;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreArticleMonthlyStatsHistory implements ShouldQueue
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
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;

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
     * @param  ArticleHistory  $event
     * @return void
     */
    public function handle(ArticleHistory $event)
    {

        $userInfo = $event->user;
        $articleInfo = $event->article;

        $year = $userInfo->school_year;

        $saveHistory = False;



        DB::beginTransaction();

        try {

            $model = ArticlesMonthlyStats::updateorCreate([
                'content_id' => $articleInfo->id,
                'client_id' => $userInfo->client_id,
                'institution_id' => $userInfo->institution_id,
                ],
                ['year_'.$year =>  DB::raw('year_'.$year.' + 1'),
                'total' =>  DB::raw('total + 1')
            ]);

            if ($model instanceof ArticlesMonthlyStats) {

                $saveHistory = True;

            } else {

                $saveHistory = False;
            }

            DB::commit();

        } catch (\Exception $e) {

            $saveHistory = False;
            DB::rollback();

        }

        return $saveHistory;
    }
}
