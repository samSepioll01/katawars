<?php

namespace Database\Factories;

use App\Models\Kata;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
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
            'description' => $this->faker->paragraph(3),
            'url' => $this->faker->url(),
            'profile_id' => Profile::all()->random()->id,
            'kata_id' => Kata::all()->random()->id,
        ];
    }
}
