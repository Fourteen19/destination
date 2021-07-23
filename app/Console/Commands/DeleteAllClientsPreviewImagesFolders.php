<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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

        //list folders directly under storage/app/public/
        $directories = Storage::disk('filemanager')->directories();
        foreach($directories as $directory)
        {
            //documents, images, preview_images, ...
            $subDirectories = Storage::disk('filemanager')->directories($directory);
            foreach($subDirectories as $subDirectory)
            {

                //if the folder constains the string 'preview_images'
                if ( Str::contains($subDirectory, 'preview_images') )
                {
                    //retrieve all the subdirectories
                    $previewFolders = Storage::disk('filemanager')->directories($subDirectory);
                    if (count($previewFolders) > 0)
                    {
                        foreach($previewFolders as $previewFolder)
                        {
                            //delete the folders
                            Storage::disk('filemanager')->deleteDirectory($previewFolder);

                        }

                    }
                }
            }
        }

        $this->info('Files/folders successfully deleted for global & all clients.');
    }
}
