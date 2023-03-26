<?php

namespace Database\Factories;

use App\Models\Kata;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VideoSolution>
 */
class VideoSolutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'youtube_code' => $this->faker->sentence(10),
            'kata_id' => Kata::all()->random()->id,
        ];
    }
}
