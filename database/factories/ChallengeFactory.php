<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $words = '';
        foreach ($this->faker->unique()->words(2) as $elem) {
            $words .= $elem . ' ';
        }

        return [
            'url' => $this->faker->unique()->url(),
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(6),
            'slug' => Str::slug($words, '-'),
            'examples' => $this->faker->text(1000),
            'notes' => $this->faker->paragraph(2)
        ];
    }
}
