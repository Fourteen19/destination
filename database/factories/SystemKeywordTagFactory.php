<?php

namespace Database\Factories;

use App\Models\SystemKeywordTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class SystemKeywordTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SystemKeywordTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'uuid' => $this->faker->uuid,
            'live' => 'Y'
        ];
    }
}
