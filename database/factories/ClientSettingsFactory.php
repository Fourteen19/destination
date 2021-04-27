<?php

namespace Database\Factories;

use App\Models\ClientSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'chat_app' => '',
            'font' => '',
        ];
    }
}
