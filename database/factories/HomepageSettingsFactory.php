<?php

namespace Database\Factories;

use App\Models\HomepageSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomepageSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HomepageSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'dashboard_slot_1_type' => 'algorithmic',
            'dashboard_slot_1_id' => NULL,
            'dashboard_slot_2_type' => 'algorithmic',
            'dashboard_slot_2_id' => NULL,
            'dashboard_slot_3_type' => 'algorithmic',
            'dashboard_slot_3_id' => NULL,
            'dashboard_slot_4_type' => 'algorithmic',
            'dashboard_slot_4_id' => NULL,
            'dashboard_slot_5_type' => 'algorithmic',
            'dashboard_slot_5_id' => NULL,
            'dashboard_slot_6_type' => 'algorithmic',
            'dashboard_slot_6_id' => NULL,
            'article_feature_slot' => 'algorithmic',
            'article_feature_slot_1' => NULL,
        ];
    }
}
