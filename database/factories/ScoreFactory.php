<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'denomination' => $this->faker->unique()->word(),
            'type' => $this->faker->word(),
            'points' => $this->faker->numberBetween(15, 100),
        ];
    }
}
