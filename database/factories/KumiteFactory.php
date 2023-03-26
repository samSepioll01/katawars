<?php

namespace Database\Factories;

use App\Models\Kata;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kumite>
 */
class KumiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        do {
            $profileID = Profile::all()->random()->id;
            $opponentID = Profile::all()->random()->id;
        } while ($profileID !== $opponentID);

        return [
            'profile_id' => $profileID,
            'kata_id' => Kata::all()->random()->id,
            'opponent_id' => $opponentID,
            'winner_id' => collect($profileID, $opponentID)->random(),
        ];
    }
}
