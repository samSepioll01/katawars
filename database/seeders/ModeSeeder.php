<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mode;

class ModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mode::create(['denomination' => 'training']);
        Mode::create(['denomination' => 'blitz']);
        Mode::create(['denomination' => 'kumite']);
    }
}
