<?php

namespace Database\Factories;

use App\Models\ContentArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentArticle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $title = $this->faker->sentence($nbWords = 6, $variableNbWords = true);
        $lead_para = $this->faker->paragraph;

        return [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'type' => 'article',
            'subheading' => $this->faker->words(5, true),
            'lead' => $lead_para,
            'body' => $this->faker->paragraphs(4, true),
            'lower_body' => $this->faker->paragraphs(2, true),
            'alt_block_heading' => $this->faker->words(5, true),
            'alt_block_text' => $this->faker->paragraphs(2, true),
            'summary_heading' => $title,
            'summary_text' => $lead_para,
        ];
    }
}
