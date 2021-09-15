<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\EventAccess;
use App\Models\LoginAccess;
use App\Models\ContentAccess;
use App\Models\VacancyAccess;
use App\Models\DashboardStats;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateDashboardStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_dashboard_stats:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is server heavy and should not be used during peak time. It reads from the database logs and updates the dashboard of all clients. Most Read articles, calculates most active institutions, ...';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info("The 'update_dashboard_stats' CRON job has started!");

        DB::beginTransaction();

        try {

            $clients = Client::select('id')->get();

            foreach($clients as $client)
            {

                //Select articles by popularity
                $articles = ContentAccess::select('content_id', DB::raw('count(content_id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->with('contentLive', function ($query) {
                                    $query->select('id', 'title');
                                })
                                ->groupBy('content_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                                ->limit(10)
                                ->get()
                                ->toArray();


                $data = ['client_id'=> $client->id, 'year_id' => app('currentYear')];

                if ($articles)
                {

                    foreach($articles as $key => $article)
                    {
                        $index = $key + 1;
                        $data['top_article_'.$index] = $article['content_live']['title'];
                        $data['top_article_'.$index.'_views'] = $article['aggregate'];

                    }

                }


                //Select institutions logins
                $institutionsLogins = LoginAccess::select('institution_id', DB::raw('count(institution_id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->with('institution', function ($query) {
                                    $query->select('id', 'name');
                                })
                                ->groupBy('institution_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                                ->limit(5)
                                ->get()
                                ->toArray();

                if ($institutionsLogins)
                {

                    foreach($institutionsLogins as $key => $login)
                    {
                        $index = $key + 1;
                        $data['top_institution_'.$index] = $login['institution']['name'];
                        $data['top_institution_'.$index.'_views'] = $login['aggregate'];
                    }

                }



                $yesterdayLogins = LoginAccess::select(DB::raw('count(id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->groupBy('client_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(1))
                                ->get();

                if (count($yesterdayLogins))
                {
                    $data['logins-1'] = $yesterdayLogins->first()->aggregate;
                }




                $weekLogins = LoginAccess::select(DB::raw('count(id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->groupBy('client_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(7))
                                ->get();

                if (count($weekLogins))
                {
                    $data['logins-7'] = $weekLogins->first()->aggregate;
                }




                $monthLogins = LoginAccess::select(DB::raw('count(id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->groupBy('client_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                                ->get();

                if (count($monthLogins))
                {
                    $data['logins-30'] = $monthLogins->first()->aggregate;
                }




                $month = date("m");
                $year = date("Y");
                if ($month < 9){
                    $year = $year - 1;
                }

                $academicLogins = LoginAccess::select(DB::raw('count(id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->groupBy('client_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>',Carbon::createMidnightDate($year, 9, 1) )
                                ->get();

                if (count($academicLogins))
                {
                    $data['logins-academic-year'] = $academicLogins->first()->aggregate;
                }



                //Select articles by popularity
                $events = EventAccess::select('event_id', DB::raw('count(event_id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->with('event', function ($query) {
                                    $query->select('id', 'title');
                                })
                                ->groupBy('event_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                                ->limit(5)
                                ->get()
                                ->toArray();

                if ($events)
                {

                    foreach($events as $key => $event)
                    {
                        $index = $key + 1;
                        $data['top_event_'.$index] = $event['event']['title'];
                        $data['top_event_'.$index.'_views'] = $event['aggregate'];
                    }

                }




                //Select articles by popularity
                $vacancies = VacancyAccess::select('vacancy_id', DB::raw('count(vacancy_id) as aggregate'))
                                ->where('client_id', $client->id)
                                ->where('year_id', app('currentYear'))
                                ->with('vacancy', function ($query) {
                                    $query->select('id', 'title');
                                })
                                ->groupBy('vacancy_id')
                                ->orderBy('aggregate', 'desc')
                                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                                ->limit(5)
                                ->get()
                                ->toArray();

                if ($vacancies)
                {

                    foreach($vacancies as $key => $vacancy)
                    {
                        $index = $key + 1;
                        $data['top_vacancy_'.$index] = $vacancy['vacancy']['title'];
                        $data['top_vacancy_'.$index.'_views'] = $vacancy['aggregate'];
                    }

                }

                //create a new statistic line in the DB
                DashboardStats::create($data);

            }

            $date  = Carbon::today()->subDays( 31 );
            ContentAccess::where( 'updated_at', '<=', $date )->delete();
            VacancyAccess::where( 'updated_at', '<=', $date )->delete();
            EventAccess::where( 'updated_at', '<=', $date )->delete();
            LoginAccess::where( 'updated_at', '<=', $date )->delete();

            DB::commit();

            $this->info("The 'update_dashboard_stats' CRON job has run Successfully!");

        } catch (\Exception $e) {

            DB::rollback();

            $this->info("The 'update_dashboard_stats'  CRON job did not run Successfully!");

        }
    }
}
