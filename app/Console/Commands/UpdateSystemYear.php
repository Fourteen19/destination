<?php

namespace App\Console\Commands;

use App\Models\Year;
use App\Models\Client;
use Illuminate\Console\Command;
use App\Models\LoginAccessTotal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UpdateSystemYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_system_year:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command creates a new academic year in the database and needs to be executed on the 1st of September';

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

        $this->info("The 'update_system_year' CRON job has started!");

        //takes a bakup of the academic year from redis or DB
        $redisCurrentYear = app('currentYear');

        DB::beginTransaction();

        try {

            $year = date('Y') + 1;

            //adds a new year in the database
            $yearModel = Year::create(['year' => $year]);

            $clients = Client::select('id')->get();

            //for each client
            foreach($clients as $client)
            {
                //creates a new line in the log table to keep a tally of the number of logins in the academic year
                LoginAccessTotal::createAccessLog($client->id, $yearModel->id);
            }

            DB::commit();

            //updates the current year in redis
            Cache::put('current:year', $yearModel->id, 3600);

            $this->info("The 'update_system_year' CRON job has run Successfully!");

        } catch (\Exception $e) {

            DB::rollback();

            //rollback the current year in redis
            Cache::put('current:year', $redisCurrentYear, 3600);

            $this->info("The 'update_system_year' CRON job did not run Successfully!");

        }

    }
}
