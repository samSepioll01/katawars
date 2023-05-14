<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Language;
use App\Models\Profile;
use App\Models\Resource;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RankSeeder::class,
            RolePermissionSeeder::class,
            AdminSeeder::class,
            ModeSeeder::class,
            LanguageSeeder::class,
            HelpSeeder::class,
            CategorySeeder::class,
            ChallengeSeeder::class,
            //VideoSolutionSeeder::class,
            ScoreSeeder::class,
        ]);

        //$this->generateChallengesKatas(10);
        //$this->generateResources(10);
    }

    /**
     * Generate the challenges and as many katas as there are languages.
     */
    private function generateChallengesKatas(int $seeds = 10): void
    {
        Challenge::factory($seeds)->create();

        for ($i = 0; $i < $seeds; $i++) {

            for ($j = 0; $j < Language::all()->count(); $j++) {

                Kata::create([
                    'challenge_id' => $i + 1,
                    'owner_id' => Profile::all()->random()->id,
                    'mode_id' => 1,
                    'language_id' => $j + 1,
                    'rank_id' => 1,
                    'uri_test' => Factory::create()->unique()->url(),
                    'signature' => Factory::create()->word(),
                    'testClassName' => Factory::create()->word(),
                ]);
            }
        }
    }

    /**
     * Generate the resources for the katas.
     */
    private function generateResources(int $seeds): void
    {
        Resource::factory($seeds)->create();
    }

}
