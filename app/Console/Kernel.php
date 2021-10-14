<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DeleteAllClientsPreviewImagesFolders::class,
        Commands\UpdateSystemYear::class,
        Commands\UpdateDashboardStats::class,
        Commands\UpdateUsersSchoolYear::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //updates the year in the system
        $schedule->command('update_system_year')->yearlyOn(9, 1, '00:00')->emailOutputTo('fred@rfmedia.co.uk');//Runs on the 1st of September

        //updates the student's school year
        $schedule->command('update_users_school_year:cron')->yearlyOn(9, 1, '00:01')->emailOutputTo('fred@rfmedia.co.uk');//Runs on the 1st of September

        //DELETION OF ALL IMAGE FOLDERS IN THE `PREVIEW_IMAGES` FOLDERS
        $schedule->command('delete_all_clients_preview_images_folders:cron')->daily()->emailOutputTo('fred@rfmedia.co.uk'); //Run the task every day at midnight

        //updates the dasboard for all clients
        $schedule->command('update_dashboard_stats:cron')->daily()->emailOutputTo('fred@rfmedia.co.uk'); //Run the task every day at midnight

        //deletes all monthly records at the end of evenry month (Hot Right Now)
        $schedule->command('clear_all_monthly_stats:cron')->monthly()->emailOutputTo('fred@rfmedia.co.uk'); //Run the task on the first day of every month at 00:00

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
