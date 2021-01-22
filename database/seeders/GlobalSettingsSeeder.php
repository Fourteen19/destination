<?php

namespace Database\Seeders;

use App\Models\GlobalSettings;
use Illuminate\Database\Seeder;

class GlobalSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        GlobalSettings::create([
            'articles_wordcount_read_per_minute' => 120,
            'topic_advisor_questions' => json_encode([ "text" => ["Option 1", "Option 2", "Option 3", "Option 4", "Option 5"] ]),
        ]);

        $this->command->info('Global Settings seeded!');

    }
}
