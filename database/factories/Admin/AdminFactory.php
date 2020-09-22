<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'email' => 'fred'.$this->faker->unique()->randomNumber.'@gmail.com',
            'password' => \Hash::make('password'),
            'role' => $this->faker->randomElement($array = array ('system_admin', 'glocal_content_admin', 'client_3rd_party', 'client_content_admin', 'client_admin', 'advisor'))
        ];
    }
}
