<?php

namespace Database\Seeders;

use App\Models\Score;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Score::create([
            'denomination' => 'follower',
            'type' => 'honor',
            'points' => 30,
        ]);

        Score::create([
            'denomination' => 'training',
            'type' => 'exp',
            'points' => 10,
        ]);

        Score::create([
            'denomination' => 'passed kata to owner',
            'type' => 'honor',
            'points' => 5,
        ]);

        Score::create([
            'denomination' => 'blitz',
            'type' => 'exp',
            'points' => 30,
        ]);

        Score::create([
            'denomination' => 'fight kumite',
            'type' => 'exp',
            'points' => 5,
        ]);

        Score::create([
            'denomination' => 'won kumite',
            'type' => 'honor',
            'points' => 50,
        ]);

        Score::create([
            'denomination' => 'lost kumite',
            'type' => 'honor',
            'points' => -50,
        ]);

        Score::create([
            'denomination' => 'like',
            'type' => 'honor',
            'points' => 10,
        ]);

        Score::create([
            'denomination' => 'add favorites',
            'type' => 'honor',
            'points' => 30,
        ]);

        Score::create([
            'denomination' => 'create resource',
            'type' => 'honor',
            'points' => 10,
        ]);

        Score::create([
            'denomination' => 'complete kataway',
            'type' => 'exp',
            'points' => 100,
        ]);

        Score::create([
            'denomination' => 'create kata',
            'type' => 'honor',
            'points' => 100,
        ]);

        Score::create([
            'denomination' => 'level-up yellow',
            'type' => 'honor',
            'points' => 100,
        ]);

        Score::create([
            'denomination' => 'level-up orange',
            'type' => 'honor',
            'points' => 250,
        ]);

        Score::create([
            'denomination' => 'level-up green',
            'type' => 'honor',
            'points' => 500,
        ]);

        Score::create([
            'denomination' => 'level-up blue',
            'type' => 'honor',
            'points' => 1000,
        ]);

        Score::create([
            'denomination' => 'level-up brown',
            'type' => 'honor',
            'points' => 1500,
        ]);

        Score::create([
            'denomination' => 'level-up black',
            'type' => 'honor',
            'points' => 3000,
        ]);
    }
}
