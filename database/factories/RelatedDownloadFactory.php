<?php

namespace Database\Factories;

use App\Models\RelatedDownload;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelatedDownloadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RelatedDownload::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Link Title',
            'URL' => 'URL',
        ];
    }
}
