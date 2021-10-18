<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\ClientVacancyHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreClientVacancyHistory implements ShouldQueue
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
     * Create the vacancy listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the vacancy.
     *
     * @param  LoginHistory  $vacancy
     * @return void
     */
    public function handle(ClientVacancyHistory $vacancy)
    {

        $current_timestamp = Carbon::now()->toDateTimeString();

        $vacancyInfo = $vacancy->vacancy;

        $saveHistory = False;

        DB::beginTransaction();

        try {

            $saveHistory = DB::table('vacancies_access')->insert(
                ['client_id' => $vacancy->clientId,
                'vacancy_id' => $vacancyInfo->id,
                'year_id' => app('currentYear'),
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp]
            );

            $saveHistory = True;

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

        }

        return $saveHistory;
    }
}
