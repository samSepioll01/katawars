<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KataWay>
 */
class KataWayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'url' => $this->faker->unique()->url(),
            'slug' => Str::slug($this->faker->unique()->sentences(2), '-'),
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'uri_image' => $this->faker->unique()->image(),
        ];
    }
}
