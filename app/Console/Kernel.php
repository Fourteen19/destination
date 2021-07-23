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
        $schedule->command('update_system_year')->yearlyOn(9, 1, '00:00');//Runs on the 1st of September

        //updates the student's school year
        $schedule->command('update_users_school_year')->yearlyOn(9, 1, '00:01');//Runs on the 1st of September

        //DELETION OF ALL IMAGE FOLDERS IN THE `PREVIEW_IMAGES` FOLDERS
        $schedule->command('delete_all_clients_preview_images_folders')->daily(); //Run the task every day at midnight



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
