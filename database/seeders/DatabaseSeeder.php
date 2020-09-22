<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        if (app()->environment() == 'production') {
            
            // seeder for production

        } else {

            //seeder for dev
            $this->call([
                AdminSeeder::class,
                ClientSeeder::class,
            ]);
        }
                
    }
}
