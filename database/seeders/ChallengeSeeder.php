<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Language;
use App\Models\Mode;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // PHP

        $phpID = Language::where('name', 'PHP')->first()->id;
        $superadminID = User::find(1)->id;
        $trainingModeID = Mode::where('denomination', 'training')->first()->id;
        $blitzModeID = Mode::where('denomination', 'blitz')->first()->id;

        // SumTwoNumbers

        $slug = Str::slug('Sum Two Numbers');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Return the Sum of Two Numbers',
            'description' => 'Create a function that takes two numbers as arguments and returns their sum.',
            'examples' => <<<EOL
                <pre><code>sum(1, 2) => 3</code></pre>
                <pre><code>sum(2, 2) => 4</code></pre>
                <pre><code>sum(52, -5) => 47</code></pre>
            EOL,
            'notes' => <<<EOL
                <ul>
                    <li>Don't forget <code>return</code> the result.</li>
                    <li>If you get stuck on a challenge, find help in the <b>Resources</b> tab.</li>
                    <li>If you're really stuck, unlock solutions in the <b>Solutions</b> tab</li>
                </ul>
            EOL,
        ]);

        $categories = [
            Category::where('name', 'math')->first()->id,
            Category::where('name', 'numbers')->first()->id,
        ];
        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'rank_id' => 1,
            'mode_id' => $trainingModeID,
            'uri_test' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/katas/php/gWYEKQHYDU3l58JVhxQM2HXlRPnzHe6ydUjkdf27.txt',
            'signature' => 'function sum($a, $b) {',
            'testClassName' => 'SumTwoNumbers',
        ]);


        // KnightsOfNi

        $slug = Str::slug('Knights Of Ni');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Knights Who Say Ni!',
            'description' => 'Create a function that return Ni! like Knights of Ni in the Monty Python and the Holy Grail film.',
            'examples' => <<<EOL
                <pre><code>say_ni() => Ni!</code></pre>
            EOL,
            'notes' => <<<EOL
                <ul>
                    <li>Don't forget <code>return</code> the result.</li>
                    <li>If you get stuck on a challenge, find help in the <b>Resources</b> tab.</li>
                    <li>If you're really stuck, unlock solutions in the <b>Solutions</b> tab</li>
                </ul>
            EOL,
        ]);

        $categories = [
            Category::where('name', 'strings')->first()->id,
        ];
        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'rank_id' => 1,
            'mode_id' => $trainingModeID,
            'uri_test' => 'https://s3.eu-south-2.amazonaws.com/katawars.es/katas/php/1yB9AsjkUKKDEHYvbZfg73bx9YBA7lgcV9SBE8Xj.txt',
            'signature' => 'function say_ni() {',
            'testClassName' => 'Ni',
        ]);

    }
}
