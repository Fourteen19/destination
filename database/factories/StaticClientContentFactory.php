<?php

namespace Database\Factories;

use App\Models\StaticClientContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticClientContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StaticClientContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'tel' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,

            'terms' => "<p>".implode("</p><p>", $this->faker->paragraphs(4))."</p>",
            'privacy' => "<p>".implode("</p><p>", $this->faker->paragraphs(4))."</p>",
            'cookies' => "<p>".implode("</p><p>", $this->faker->paragraphs(4))."</p>",

            'pre_footer_heading' => "How to get advice",
            'pre_footer_body' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",
            'pre_footer_button_text' => "CLICK HERE FOR MORE INFORMATION",
            'pre_footer_link' => NULL,

            'login_intro' => "To access MyDirections please login using the form below",
            'welcome_intro' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",
            'careers_intro' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",
            'subjects_intro' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",
            'routes_intro' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",
            'sectors_intro' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",
            'assessment_completed_txt' => "<p>".implode("</p><p>", $this->faker->paragraphs(1))."</p>",

            'support_block_heading' => $this->faker->sentence,
            'support_block_body' => "<p>".implode("</p><p>", $this->faker->paragraphs(2))."</p>",
            'support_block_button_text' => 'CLICK HERE TO UPDATE YOUR ACCOUNT SETTINGS',
            'support_block_link' => NULL,
            'get_in_right_heading' => 'Are we getting it right?',
            'get_in_right_body' => "<p>".implode("</p><p>", $this->faker->paragraphs(2))."</p>",

            'login_block_heading' => 'Already have a MyDirections account?',
            'login_block_body' => implode("", $this->faker->paragraphs(1)),
        ];

    }
}
