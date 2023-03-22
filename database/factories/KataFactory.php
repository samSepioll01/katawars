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
            'mode_id' => Mode::all()->random()->id,
            'language_id' => Language::all()->random()->id,
            'rank_id' => Rank::all()->random()->id,
        ];
    }
}
