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

        $TagsTypes = ['sector', 'route', 'role-type', 'term', 'subject'];

        foreach($TagsTypes as $TagsType) {

            //create a tag
            SystemTag::factory()->times(3)->create([
                'type' => $TagsType,
            ]);

            $this->command->info($TagsType.' Tags created!');

        }


        $TagsYearGroupsTags= ['7', '8', '9', '10', '11', '12', '13', 'post'];
        foreach($TagsYearGroupsTags as $TagsYearGroupsTag) {
            SystemTag::create([
                'type' => 'year',
                'name' => $TagsYearGroupsTag,
                'live' => 'Y'
            ]);
        }
        $this->command->info('Year Groups Tags created!');



        $LscsTags= ['1-2', '2-3', '3-4', '4-5'];
        foreach($LscsTags as $LscsTag) {
            SystemTag::create([
                'type' => 'lscs',
                'name' => $LscsTag,
                'live' => 'Y'
            ]);
        }
        $this->command->info('Life Stage Careers Score LSCS Tags created!');


        SystemTag::create([
            'type' => 'flag',
            'name' => 'High Priority',
            'live' => 'Y'
        ]);

        SystemTag::create([
            'type' => 'flag',
            'name' => 'Red flag',
            'live' => 'Y'
        ]);

        SystemTag::create([
            'type' => 'flag',
            'name' => 'Report to users profile',
            'live' => 'Y'
        ]);

        $this->command->info('Tags Table seeded!');

    }
}
