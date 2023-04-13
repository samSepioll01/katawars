<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'slug' => Str::slug(
                collect($this->faker->unique()->words(2))->join(' ')
            ),
            'url' => $this->faker->unique()->url(),
            'exp' => 0,
            'honor' => 0,
            'is_darkmode' => false,
            'is_banned' => false,
            'is_deleted' => false,
            'rank_id' => 1,
        ];
    }
}
