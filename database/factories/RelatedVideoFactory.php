<?php

namespace Database\Factories;

use App\Models\relatedVideo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RelatedVideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = relatedVideo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'some URL',
        ];
    }
}
