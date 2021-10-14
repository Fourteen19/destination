<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\ArticleHistory;
use App\Models\ArticlesTotalStats;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreArticleTotalStatsHistory implements ShouldQueue
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

        $userInfo = $event->user;
        $articleInfo = $event->article;

        $year = $userInfo->school_year;

        $saveHistory = False;


        DB::beginTransaction();

        try {

            $model = ArticlesTotalStats::updateorCreate(
                ['content_id' => $articleInfo->id,
                'client_id' => $userInfo->client_id,
                'institution_id' => $userInfo->institution_id,
                'year_id' => app('currentYear'),
                ],
                ['year_'.$year =>  DB::raw('year_'.$year.' + 1'),
                'total' =>  DB::raw('total + 1')
                ]
            );

            if ($model instanceof ArticlesTotalStats) {

                //saves the stat at the client level. This is a counter for all institutions
                $model = ArticlesTotalStats::updateorCreate(
                    ['content_id' => $articleInfo->id,
                    'client_id' => $userInfo->client_id,
                    'institution_id' => NULL,
                    'year_id' => app('currentYear'),
                    ],
                    ['year_'.$year =>  DB::raw('year_'.$year.' + 1'),
                    'total' =>  DB::raw('total + 1')
                    ]
                );

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
