<?php

namespace Database\Factories;

use App\Models\PageHomepage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageHomepageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageHomepage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $lead_para = $this->faker->paragraph;

        return [
            'banner_title' => 'banner title',
            'banner_text' => "banner text",
        ];
    }
}
