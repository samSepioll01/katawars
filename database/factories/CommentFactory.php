<?php

namespace Database\Factories;

use App\Models\Challenge;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'profile_id' => Profile::all()->random()->id,
            'challenge_id' => Challenge::all()->random()->id,
            'body' => $this->faker->paragraph(),
        ];
    }
}
