<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUsersSchoolYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_users_school_year:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command updates the school year of all users in the system';

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

            //update the school year of students who are not in POST education (year 14)
            User::where('school_year', '<', 14)
                ->where('type', 'user')
                ->chunkById(200, function ($users) {
                    $users->each->update(['school_year' => DB::raw('school_year + 1')]);
            }, $column = 'id');

            DB::commit();

            $this->info("The 'update_users_school_year' CRON job has run Successfully!");

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollback();

            $this->info("The 'update_users_school_year'  CRON job did not run Successfully!");

        }
    }
}
