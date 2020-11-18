<?php

namespace Database\Factories;

use App\Models\SystemTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class SystemTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SystemTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'live' => 'Y'
        ];
    }
}
