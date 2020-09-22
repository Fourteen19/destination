<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Persists records in DB
        Admin::factory()->times(30)->create();
        
        $this->command->info('Admin table seeded!');
       
    }
}
