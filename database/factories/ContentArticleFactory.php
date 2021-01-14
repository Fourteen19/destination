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
//            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'type' => 'article',
            'subheading' => $this->faker->words(5, true),
            'lead' => $lead_para,
            'body' => "<p>".implode("</p><p>", $this->faker->paragraphs(4))."</p>",
            'lower_body' => "<p>".implode("</p><p>", $this->faker->paragraphs(2))."</p>",
            'alt_block_heading' => $this->faker->words(5, true),
            'alt_block_text' => "<p>".implode("</p><p>", $this->faker->paragraphs(2))."</p>",
        ];
    }
}
