<?php

namespace App\Console\Commands;

use App\Models\Year;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {

            //adds a new year in the database
            Year::create(['year' => date('Y') + 1]);

            DB::commit();

            $this->info("The 'update_system_year' CRON job has run Successfully!");

        } catch (\Exception $e) {

            DB::rollback();

            $this->info("The 'update_system_year' CRON job did not run Successfully!");

        }


    }
}
