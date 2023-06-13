<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ScoreSeeder::class,
            UserSeeder::class,
            KatawaySeeder::class,
            ResourceSeeder::class,
            VideoSolutionSeeder::class,
        ]);
    }
}
