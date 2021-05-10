<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteAllClientsPreviewImagesFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_all_clients_preview_images_folders:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all the global & clients folders\files located in `preview_images` folders. These folders are used when creating/editing content.';

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






        $this->info('Files/folders successfully deleted for global & all clients.');
    }
}
