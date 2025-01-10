<?php

namespace Modules\Codes\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Codes\models\Code::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'          => $this->faker->unique()->numerify('###############'),
            'duration'      => $this->faker->randomElement(['daily', 'weekly', 'monthly', 'yearly', 'life_time']),
            'status'        => $this->faker->randomElement(['pending', 'ended', 'active', 'suspended']),
            'expire_at'     => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
