<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemTag;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Tags Table seeding starts!');

        $TagsTypes = ['Sectors', 'Routes', 'Role Types', 'Terms', 'Subjects'];

        foreach($TagsTypes as $TagsType) {

            //create a tag
            SystemTag::factory()->times(3)->create([
                'type' => $TagsType,
            ]);

            $this->command->info($TagsType.' Tags created!');

        }

        $this->command->info('Tags Table seeded!');

    }
}
