<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url(),
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(6),
            'slug' => $this->faker->word(),
            'examples' => $this->faker->text(1000),
            'notes' => $this->faker->paragraph(2)
        ];
    }
}
