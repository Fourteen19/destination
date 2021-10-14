<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearAllMonthlyStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear_all_monthly_stats:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command empties the `articles_monthly_stats` table. Reset of the "Hot Right Now" feature.';

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

            DB::table('articles_monthly_stats')->delete();

            DB::commit();

            $this->info("The 'clear_all_monthly_stats' CRON job has run Successfully!");

        } catch (\Exception $e) {

            DB::rollback();

            $this->info("The 'clear_all_monthly_stats'  CRON job did not run Successfully!");

        }
    }
}
