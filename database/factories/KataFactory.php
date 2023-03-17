<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kata>
 */
class KataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'owner_id' => Profile::all()->random()->id,
            'mode_id' => 1,
            'language_id' => Language::all()->random()->id,
            'rank_id' => 1,
        ];
    }
}
