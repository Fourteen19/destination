<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){

        return [
            'uuid' => $this->faker->uuid,
            'first_name' => $this->faker->firstNameMale,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => \Hash::make('password')
        ];

    }
}
