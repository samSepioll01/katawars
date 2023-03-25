<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
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
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => false,
            'is_banned' => false,
            'is_deleted' => false,
            'rank_id' => 1,
        ];
    }
}
