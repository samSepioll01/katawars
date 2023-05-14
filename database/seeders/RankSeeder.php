<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::create(['name' => 'white', 'level_up' => 100]);
        Rank::create(['name' => 'yellow', 'level_up' => 200]);
        Rank::create(['name' => 'orange', 'level_up' => 300]);
        Rank::create(['name' => 'green', 'level_up' => 400]);
        Rank::create(['name' => 'blue', 'level_up' => 500]);
        Rank::create(['name' => 'brown', 'level_up' => 600]);
        Rank::create(['name' => 'black', 'level_up' => 700]);
    }
}
