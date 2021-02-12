<?php

namespace Database\Factories;

use App\Models\PageStandard;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageStandardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageStandard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $lead_para = $this->faker->paragraph;

        return [
            'lead' => $lead_para,
            'body' => "<p>".implode("</p><p>", $this->faker->paragraphs(4))."</p>",
        ];
    }
}
