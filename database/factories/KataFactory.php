<?php

namespace Database\Factories;

use App\Models\Challenge;
use App\Models\Language;
use App\Models\Mode;
use App\Models\Profile;
use App\Models\Rank;
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
            'challenge_id' => Challenge::all()->random()->id,
            'owner_id' => Profile::all()->random()->id,
            'mode_id' => 1,
            'language_id' => Language::all()->random()->id,
            'rank_id' => 1,
            'uri_test' => $this->faker->unique()->file(),
            'signature' => $this->faker->word(),
            'testClassName' => $this->faker->word(),
        ];
    }
}
