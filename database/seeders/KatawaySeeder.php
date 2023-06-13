<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\Kataway;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KatawaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kataways Arrays

        $title = 'Arrays, Master It Up!';
        $slug = Str::slug($title);

        $kataway = Kataway::create([
            'title' => $title,
            'slug' => $slug,
            'url' => url("/$slug"),
            'description' => 'This is the kataways where impruve your skills to work with arrays. Enjoy Coding!',
            'owner_id' => User::find(1)->profile->id,
        ]);

        $challenges = Challenge::whereHas('categories', fn($query) => $query->where('name', 'arrays'))->get();
        $challenges = $challenges->filter(
            fn($challenge) => $challenge->katas->first()->mode_id !== 2
        );
        $katasIDs = $challenges->map(fn($challenge) => $challenge->katas->first()->id);
        $kataway->katas()->sync($katasIDs);


        // Kataways String

        $title = 'Strings, Master It Up!';
        $slug = Str::slug($title);

        $kataway = Kataway::create([
            'title' => $title,
            'slug' => $slug,
            'url' => url("/$slug"),
            'description' => 'This is the kataways where impruve your skills to work with strings. Enjoy Coding!',
            'owner_id' => User::find(1)->profile->id,
        ]);

        $challenges = Challenge::whereHas('categories', fn($query) => $query->where('name', 'strings'))->get();
        $challenges = $challenges->filter(
            fn($challenge) => $challenge->katas->first()->mode_id !== 2
        );
        $katasIDs = $challenges->map(fn($challenge) => $challenge->katas->first()->id);
        $kataway->katas()->sync($katasIDs);

        // Kataways Math

        $title = 'Maths, Master It Up!';
        $slug = Str::slug($title);

        $kataway = Kataway::create([
            'title' => $title,
            'slug' => $slug,
            'url' => url("/$slug"),
            'description' => 'This is the kataways where impruve your coding skills to work with Mathematical problems. Enjoy Coding!',
            'owner_id' => User::find(1)->profile->id,
        ]);

        $challenges = Challenge::whereHas('categories', fn($query) => $query->where('name', 'math'))->get();
        $challenges = $challenges->filter(
            fn($challenge) => $challenge->katas->first()->mode_id !== 2
        );
        $katasIDs = $challenges->map(fn($challenges) => $challenges->katas->first()->id);
        $kataway->katas()->sync($katasIDs);
    }
}
