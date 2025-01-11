<?php

namespace Modules\Users\Database\Factories;

use Modules\Countries\App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Users\App\Models\User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->name,
            'first_name'    => $this->faker->name,
            'last_name'     => $this->faker->name,
            'email'         => $this->faker->unique()->safeEmail,
            'mobile'        => fkr()->phoneNumber(),
            'account_type'  => 'user',
            'status'        => 'unsubscribed',
            'password'      => bcrypt(123456),
            'first_name'    => 'first_name',
            'last_name'     => 'last_name',
        ];
    }
}
