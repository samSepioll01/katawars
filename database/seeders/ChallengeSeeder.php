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
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Create a function that takes two numbers as arguments and returns their sum.</p>
            EOL,
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/gWYEKQHYDU3l58JVhxQM2HXlRPnzHe6ydUjkdf27.txt',
            'signature' => 'function sum($a, $b) {',
            'testClassName' => 'SumTwoNumbers',
        ]);


        // KnightsOfNi

        $slug = Str::slug('Knights Of Ni');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Knights Who Say Ni!',
            'rank_id' => 1,
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/1yB9AsjkUKKDEHYvbZfg73bx9YBA7lgcV9SBE8Xj.txt',
            'signature' => 'function say_ni() {',
            'testClassName' => 'Ni',
        ]);


        // PrimeFactors

        $slug = Str::slug('Prime Factors');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Get the Prime Factors of a number.',
            'rank_id' => 4,
            'description' => <<<EOL
                <p>Write a function called <code>prime_factors</code> that takes a positive integer <code>n</code> as an argument and returns an indexed array with the prime factors of <code>n</code> sorted from smallest to largest.</p>
                <p>The prime factors of a number are the prime numbers that divide it exactly. For example, the prime factors of 15 are 3 and 5, and the prime factors of 100 are 2 and 5 (with multiplicity 2). If the number is prime, the function should return an array with the same number as the only element. If the number is less than 2, the function should return an empty array.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>prime_factors(15) => [3, 5]</code></pre>
                <pre><code>prime_factors(100) => [2, 2, 5, 5]</code></pre>
                <pre><code>prime_factors(17) => [17]</code></pre>
                <pre><code>prime_factors(1) => []</code></pre>
            EOL,
            'notes' => <<<EOL
                <ul>
                    <li><b>Remember</b> if the number is less than 2 must return empty array</li>
                    <li>Don't forget <code>return</code> the result.</li>
                    <li>If you get stuck on a challenge, find help in the <b>Resources</b> tab.</li>
                    <li>If you're really stuck, unlock solutions in the <b>Solutions</b> tab</li>
                </ul>
            EOL,
        ]);

        $categories = [
            Category::where('name', 'math')->first()->id,
            Category::where('name', 'numbers')->first()->id,
            Category::where('name', 'arrays')->first()->id,
            Category::where('name', 'algorithms')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/I0fL7dZCeykHK1If4vKiUrsnPrPUhQnXwmLvptrU.txt',
            'signature' => 'function prime_factors() {',
            'testClassName' => 'PrimeFactors',
        ]);


        // RomanNumeral

        $slug = Str::slug('Roman Numerals');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Generate Roman Numerals.',
            'rank_id' => 4,
            'description' => <<<EOL
                <p>Write a function called <code>generate</code> that takes a positive integer <code>n</code> as an argument and returns a string with the Roman numeral equivalent of <code>n</code>.</p>
                <p>The Roman numerals are symbols used in a system of numerical notation based on the ancient Roman system. The symbols are I, V, X, L, C, D, and M, standing respectively for 1, 5, 10, 50, 100, 500, and 1,000 in the Hindu-Arabic numeral system.</p>
                <p>A symbol placed after another of equal or greater value adds its value—e.g., II = 1 + 1 = 2 and LVII = 50 + 5 + 1 + 1 = 57. Usually only three identical symbols can be used consecutively; to express numbers beginning with a 4 or a 9, a symbol is placed before one of greater value to subtract its value—e.g., IV = −1 + 5 = 4, XC = −10 + 100 = 90, and CD = −100 + 500 = 400.</p>
                <p>The exceptions are 4,000, which is sometimes written as MMMM. If the number is greater than 3,999 or less than 1, the function should return an empty string.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>generate(1) => "I"</code></pre>
                <pre><code>generate(15) => "XV"</code></pre>
                <pre><code>generate(100) => "C"</code></pre>
                <pre><code>generate(2023) => "MMXXIII"</code></pre>
                <pre><code>generate(3999) => "MMMCMXCIX"</code></pre>
                <pre><code>generate(4000) => ""</code></pre>
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
            Category::where('name', 'loops')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/zHxM8zRS2Ec1DDEbmuowvoSKALnVCgwZQSsg6FPR.txt',
            'signature' => 'function generate() {',
            'testClassName' => 'RomanNumerals',
        ]);

        // BowlingScore

        $slug = Str::slug('Bowling Score');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Get de Bowling Score for a Game!.',
            'rank_id' => 7,
            'description' => <<<EOL
                <p>Write a function called <code>bowling_score</code> that takes an array of integers <code>rolls</code> as an argument and returns an integer with the total score of the bowling game. The array <code>rolls</code> contains the number of pins knocked down on each roll of the game. A bowling game consists of 10 frames, with a minimum score of zero and a maximum of 300. Each frame consists of two chances to knock down ten pins, except for the 10th frame, which can have up to three rolls depending on the outcome of the first two.</p>
                <p>The scoring rules are as follow:</p>
                <p>
                    <ul>
                        <li>If you knock down all 10 pins on your first roll, it’s called a strike. A strike is worth 10 points plus the number of pins on your next two rolls</li>
                        <li>If you knock down all 10 pins on your second roll, it’s called a spare. A spare is worth 10 points plus the number of pins on your next roll</li>
                        <li>If you fail to knock down all 10 pins in a frame, it’s called an open frame. An open frame is worth the number of pins you knocked down on both rolls</li>
                        <li>If you get a spare or a strike on the 10th frame, you get one or two extra rolls respectively to complete your score</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>bowling_score([10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]) => 300</code></pre>
                <pre><code>bowling_score([5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]) => 150</code></pre>
                <pre><code>bowling_score([4, 4, 4, 4, 4, 4, 4, 4, 4, 4]) => 80</code></pre>
                <pre><code>bowling_score([10, 5, 5, 10, 5, 5, 10, 5, 5, 10, 5, 5]) => 200</code></pre>
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
            Category::where('name', 'loops')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/FIqagqNECuGTkDsAqp3reJ3TIPjXHWKdnqzUICQY.txt',
            'signature' => 'function bowling_score($rolls) {',
            'testClassName' => 'BowlingScore',
        ]);


        // String Calculator

        $slug = Str::slug('String Calculator');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'String Calculator with Delimiter.',
            'rank_id' => 2,
            'description' => <<<EOL
                <p>Write a function called <code>str_calc</code> that takes two strings as arguments: <code>delimiter</code> and <code>str</code>. The function should return an integer with the sum of the digits that are separated by the delimiter in the string <code>str</code>.</p>
                <p>The delimiter can be any character, and the string <code>str</code> can contain any number of digits and delimiters.</p>
                <p>If the string <code>str</code> is empty or does not contain any digits, the function should return zero.</p>
                <p>If the string <code>str</code> contains any characters that are not digits or delimiters, the function should ignore them.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>str_calc(",", "3,4") => 7</code></pre>
                <pre><code>str_calc(",", "14,20") => 34</code></pre>
                <pre><code>str_calc(":", "1956:249") => 2205</code></pre>
                <pre><code>str_calc("-", "1-1") => 2</code></pre>
                <pre><code>str_calc(",", "0,0") => 0</code></pre>
                <pre><code>str_calc(";", "a;2;b;3;c;4") => 9</code></pre>
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
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/rrvYnZ6YoFkYuBYbSO3e2bMWRTLNvl6eqtQGSqpV.txt',
            'signature' => 'function str_calc($delimiter, $str) {',
            'testClassName' => 'StringCalculator',
        ]);


        // Tennis Match

        $slug = Str::slug('Tennis Match');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Call the points for a Tennis Match.',
            'rank_id' => 3,
            'description' => <<<EOL
                <p>Write a function called <code>scoreTo</code> that takes two integers as arguments: <code>pointsP1</code> and <code>pointsP2</code>. The function should return a string with the tennis score corresponding to the points of player 1 and player 2.</p>
                <p>The tennis score is based on a system of points, games, and sets. A point is scored when a player hits the ball in such a way that the opponent is unable to return it, or if the opponent hits the ball out of bounds. A game is won by the player who is able to score four points and win by a margin of at least two points. A set is won by the first side to win six games, with a margin of at least two games over the other side. A match is won when a player or a doubles team has won the majority of the prescribed number of sets.</p>
                <p>The scoring rules are as follows:</p>
                <p>
                    <ul>
                        <li>If both players have zero points, the score is “love all”.</li>
                        <li>If one player has zero points and the other has 15, 30, or 40 points, the score is “love” followed by the other player’s points. For example, “love fifteen” or “love forty”.</li>
                        <li>If both players have 15, 30, or 40 points, the score is their points followed by “all”. For example, “fifteen all” or “thirty all”.</li>
                        <li>If both players have 40 points, the score is “deuce”.</li>
                        <li>If one player has more than 40 points and has a one-point advantage over the other, the score is “advantage player 1” or “advantage player 2”, depending on who has the advantage.</li>
                        <li>If one player has more than 40 points and has a two-point advantage over the other, they win the game and the score is “game player 1” or “game player 2”, depending on who won.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>scoreTo(40, 40) => "deuce"</code></pre>
                <pre><code>scoreTo(15, 0) => "fifteen love"</code></pre>
                <pre><code>scoreTo(30, 30) => "thirty all"</code></pre>
                <pre><code>scoreTo("A", 40) => "adventage player 1"</code></pre>
                <pre><code>scoreTo(40, A) => "adventage player 2"</code></pre>
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
            Category::where('name', 'algorithms')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/aX85dHP0sgyN373LSsam6fskDXCLGONGEsUYRrL2.txt',
            'signature' => 'function scoreTo($pointsP1, $pointsP2) {',
            'testClassName' => 'TennisMatch',
        ]);


        // FizzBuzz

        $slug = Str::slug('FizzBuzz');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'FizzBuzz',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Write a function called <code>fizzbuzz</code> that takes an integer <code>number</code> as an argument and returns a string or an integer depending on the value of <code>number</code>.</p>
                <p>The function should follow these rules:</p>
                <p>
                    <ul>
                        <li>If <code>number</code> is divisible by both 3 and 5, return the string “FizzBuzz”.</li>
                        <li>If <code>number</code> is divisible by only 3, return the string “Fizz”.</li>
                        <li>If <code>number</code> is divisible by only 5, return the string “Buzz”.</li>
                        <li>If <code>number</code> is not divisible by either 3 or 5, return the same number.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>fizzbuzz(3) => "Fizz"</code></pre>
                <pre><code>fizzbuzz(5) => "Buzz"</code></pre>
                <pre><code>fizzbuzz(10) => "Buzz"</code></pre>
                <pre><code>fizzbuzz(15) => "FizzBuzz"</code></pre>
                <pre><code>fizzbuzz(2) => 2</code></pre>
                <pre><code>fizzbuzz(75) => "FizzBuzz"</code></pre>
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
            Category::where('name', 'numbers')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/NXr1sU2GtHsL21kswJG16lQzDVWYkHZApI2jOV7t.txt',
            'signature' => 'function fizzbuzz($number) {',
            'testClassName' => 'FizzBuzz',
        ]);



        // Song Bottles

        $slug = Str::slug('Song 99 Bottles');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => '99 Bottles Song Verses',
            'rank_id' => 7,
            'description' => <<<EOL
                <p>Write a class called <code>Song</code> that has a method called <code>verse</code> that takes an integer <code>n</code> as an argument and returns a string with the lyrics of the song “99 Bottles of Beer”. The song is about someone who drinks 99 bottles of beer, one by one, until there are no more bottles left. The lyrics of each verse depend on the number of bottles remaining, as shown in the test cases. The method should handle any number from 0 to 99.</p>
            EOL,
            'examples' => <<<EOL
                <pre>
                    <code>(new Song()->verse(99)</code>:
                        <p>99 bottles of beer on the wall</p>
                        <p>99 bottles of beer</p>
                        <p>Take one down and pass it around</p>
                        <p>98 bottles of beer on the wall</p>
                </pre>
                <pre>
                    <code>(new Song()->verse(2)</code>:
                        <p>2 bottles of beer on the wall</p>
                        <p>2 bottles of beer</p>
                        <p>Take one down and pass it around</p>
                        <p>1 bottles of beer on the wall</p>
                </pre>
                <pre>
                    <code>(new Song()->verse(1)</code>:
                        <p>1 bottles of beer on the wall</p>
                        <p>1 bottles of beer</p>
                        <p>Take one down and pass it around</p>
                        <p>No more bottles of beer on the wall</p>
                </pre>
                <pre>
                    <code>(new Song()->verse(0)</code>:
                        <p>No more bottles of beer on the wall</p>
                        <p>No more bottles of beer</p>
                        <p>Go to the store and buy some more</p>
                        <p>99 bottles of beer on the wall</p>
                </pre>
            EOL,
            'notes' => <<<EOL
                <ul>
                    <li>The numbers passed will be between 99 and 0 both includes.</li>
                    <li>The name of class must be <code>Song</code> and the method to generate <code>verse</code></li>
                    <li><b>Optionaly:</b> Implement a <code>sing()</code> and <code>verses()</code> methods if want sing all the song.</li>
                    <li>If you get stuck on a challenge, find help in the <b>Resources</b> tab.</li>
                    <li>If you're really stuck, unlock solutions in the <b>Solutions</b> tab</li>
                </ul>
            EOL,
        ]);

        $categories = [
            Category::where('name', 'objects')->first()->id,
            Category::where('name', 'strings')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/reVLFVb2tMN0UCI4TXsrTIgNbdlJ9cmGiozL1z3l.txt',
            'signature' => 'class Song { public function verse($number) {',
            'testClassName' => 'SongBottles',
        ]);



        // ReverseString

        $slug = Str::slug('Reverse String');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Reverse the String',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Write a function called <code>reverse</code> that takes a string <code>str</code> as an argument and returns a string with the characters of <code>str</code> in reverse order.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>reverse("string") => "gnirts"</code></pre>
                <pre><code>reverse("katawars") => "srawatak"</code></pre>
                <pre><code>reverse("house") => "esuoh"</code></pre>
                <pre><code>reverse("donana") => "ananod"</code></pre>
                <pre><code>reverse("mistakes") => "sekatsim</code></pre>
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
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/xuYaIyBR2nLGILvI1iUdD9YdGqCazfYavoiWalnG.txt',
            'signature' => 'function reverse($str) {',
            'testClassName' => 'ReverseString',
        ]);


        // SlugString

        $slug = Str::slug('Slug String');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Convert a String in a Slug.',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Write a function called <code>str_slug</code> that takes a string <code>str</code> as an argument and returns a string with the format of a slug. A slug is a string that is used to identify a resource in a URL, and it usually consists of lowercase alphanumeric characters separated by hyphens. </p>
                <p>The function should follow these rules:</p>
                <p>
                    <ul>
                        <li>If <code>str</code> contains any uppercase letters, convert them to lowercase.</li>
                        <li>If <code>str</code> contains any spaces, replace them with hyphens.</li>
                        <li>If <code>str</code> contains any punctuation marks or symbols, such as <code>.</code>, <code>,</code>, <code>!</code>, <code>?</code>, <code>@</code>, <code>_</code>, etc., replace them with hyphens.</li>
                        <li>If <code>str</code> contains any consecutive hyphens, replace them with a single hyphen.</li>
                        <li>If <code>str</code> starts or ends with a hyphen, remove it.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>str_slug("House of Cards") => "house-of-cards"</code></pre>
                <pre><code>str_slug("Game of Thrones") => "games-of-thrones"</code></pre>
                <pre><code>str_slug("Spiderman 2") => "spiderman-2"</code></pre>
                <pre><code>str_slug("info.email") => "info-email"</code></pre>
                <pre><code>str_slug("sandman_want_water") => "sandman-want-water"</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/ShMP94Zlqb1EwS0JbRCg7t4yIqqNNy4SFWhT3KgD.txt',
            'signature' => 'function str_slug($str) {',
            'testClassName' => 'SlugString',
        ]);


        // FootballPoints

        $slug = Str::slug('Football Points');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Get Points for the matchs of the Football Team.',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Create a function called <code>points</code> that takes three arguments: <code>wins</code>, <code>draws</code> and <code>losses</code>. These are integers that represent the number of wins, draws and losses that a football team has had in a season.</p>
                <p>The function should return the total number of points that the team has earned, according to the following rules:</p>
                <p>
                    <ul>
                        <li>A win is worth 3 points.</li>
                        <li>A draw is worth 1 point.</li>
                        <li>A lose is worth 0 points.</li>
                    </ul>
                </p>
                <p>For example, if a team has 4 wins, 3 draws and 2 losses, they have 15 points.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>points(3, 4, 2) => 13</code></pre>
                <pre><code>points(5, 5, 5) => 20</code></pre>
                <pre><code>points(1, 0, 0) => 3</code></pre>
                <pre><code>points(0, 0, 15) => 0</code></pre>
                <pre><code>points(0, 7, 0) => 7</code></pre>
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
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/9BdJ149FOheyNItlOMs7dkHAXjkB4EbWiSUODijA.txt',
            'signature' => 'function points($wins, $draws, $loses) {',
            'testClassName' => 'FootballPoints',
        ]);



        // CapitalizeAll

        $slug = Str::slug('Capitalize All');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Capitalize all words of a string.',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Create a function called <code>capitalize_all</code> that takes one argument: <code>str</code>. This is a string that contains one or more words. The function should return a new string that has the first letter of every word capitalized.</p>
                <p>For example, if the input string is “hello world”, the output string should be “Hello World”.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>capitalize_all("hello world") => "Hello World"</code></pre>
                <pre><code>capitalize_all("katawars is great") => "Katawars Is Great"</code></pre>
                <pre><code>capitalize_all("in a site of la mancha...") => "In A Site Of La Mancha..."</code></pre>
                <pre><code>capitalize_all("kobe bryant") => Kobe Bryant</code></pre>
                <pre><code>capitalize_all("alice throught the mirror") => "Alice Throught The Mirror"</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/LpQXY4M8Qw9CnytUDWNtONpIbLVRf3DBn46JwVr6.txt',
            'signature' => 'function capitalize_all($str) {',
            'testClassName' => 'CapitalizeAll',
        ]);



        // Palindrome

        $slug = Str::slug('Palindrome');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Check Palindrome Strings.',
            'rank_id' => 4,
            'description' => <<<EOL
                <p>Create a function called <code>isPalindrome</code> that takes one argument: <code>str</code>. This is a string that may contain punctuation marks and spaces. The function should return a boolean value that indicates whether the string is a palindrome or not.</p>
                <p>A palindrome is a word or phrase that reads the same forward and backward, ignoring punctuation marks and spaces.</p>
                <p>For example, “A man, a plan, a canal, Panama!” is a palindrome.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>isPalindrome("A man, a plan, a canal, Panama!") => true</code></pre>
                <pre><code>isPalindrome("Was it a car or a cat I saw?") => true</code></pre>
                <pre><code>isPalindrome("No 'x' in Nixon") => true</code></pre>
                <pre><code>isPalindrome("This is not a palindrome") => false</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/6v1mgUS7AxAmg4RzKWGnsSnNNSBTd4pBsFJE24dp.txt',
            'signature' => 'function isPalindrome($str) {',
            'testClassName' => 'PalindromeTest',
        ]);


        // Count Substring

        $slug = Str::slug('Count Substring');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Count the repeats of substring.',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Create a function called <code>count_str</code> that takes two arguments: <code>haystack</code> and <code>needle</code>. These are both strings. The function should return an integer that represents the number of times that the <code>needle</code> string appears as a substring in the <code>haystack</code> string.</p>
                <p>For example, if the <code>haystack</code> string is “The Knights Of ni never lose” and the <code>needle</code> string is “ni”, the function should return 2.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>count_str("The Knights Of ni never lose", "ni") => 2</code></pre>
                <pre><code>count_str("Willy Wonka on fire", "on") => 2</code></pre>
                <pre><code>count_str("Alice in Wonderland", "fly") => 0</code></pre>
                <pre><code>count_str("The Caesar Palace theatre have the best show in the world", "the") => 4</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/5hTH3wO9QL4T2GgLlsJKJedpSNgz7er9hxiaQvUg.txt',
            'signature' => 'function count_str($haystack, $needle) {',
            'testClassName' => 'CountSubstring',
        ]);


        // Array First

        $slug = Str::slug('Array First');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Returning the First element in the Array.',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Create a function called <code>array_first</code> that takes one argument: <code>arr</code>. This is an array that contains different strings. The function should return the first element of the array.</p>
                <p>For example, if the array is <code>['Lancelot', 'Dartagnan', 'Alatriste']</code>, the function should return ‘Lancelot’.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>array_first(['Lancelot', 'Dartagnan', 'Alatriste']) => 'Lancelot'</code></pre>
                <pre><code>array_first(['Venom', 'Sandman', 'Octopus', 'Kindpin']) => 'Venom'</code></pre>
                <pre><code>array_first(['Spain', 'Croatia', 'USA', 'New Zeland']) => 'Spain'</code></pre>
                <pre><code>array_first(['PHP', 'C', 'Javascript', 'Python']) => 'PHP'</code></pre>
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
            Category::where('name', 'arrays')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/W1J562yAOH12uMJ7WT0wEd65BuvDPD9JYvv51EtJ.txt',
            'signature' => 'function array_first($arr) {',
            'testClassName' => 'ArrayFirst',
        ]);


        // Array Filtered

        $slug = Str::slug('Array Filtered');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Array Filtered for Greater Than Number.',
            'rank_id' => 3,
            'description' => <<<EOL
                <p>Create a function called <code>filtered</code> that takes two arguments: <code>arr</code> and <code>num</code>. These are an array of numbers and a number, respectively. The function should return a new array that contains only the elements of the original array that are greater than the number.</p>
                <p>For example, if the array is <code>[-53, 1544, 12, 0, -511, 2]</code> and the number is <code>0</code>, the function should return <code>[1544, 12, 2]</code>.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>filtered(range(1,7), 7) => []</code></pre>
                <pre><code>filtered([-53, 1544, 12, 0, -511, 2], 0) => [1544, 12, 2]</code></pre>
                <pre><code>filtered([1,2,3,4,5], 0) => [1,2,3,4,5]</code></pre>
                <pre><code>filtered([-200, -50, 0, 1], -100) => [-50, 0, 1]</code></pre>
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
            Category::where('name', 'arrays')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/ih6Oc5lEzTS2j30MugMVcIXCHkPkB4K8YU2xWk1f.txt',
            'signature' => 'function filtered($arr) {',
            'testClassName' => 'ArrayFiltered',
        ]);


        // Array To String

        $slug = Str::slug('Array To String');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Convert the Array content To a String.',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Create a function called <code>arr2string</code> that takes one argument: <code>arr</code>. This is an array that contains individual characters in each position. The function should return a string that is composed of the characters of the array.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>arr2string(['H','e','l','l','o',' ','F','o','l','k','s','!']) => "Hello Folks!"</code></pre>
                <pre><code>arr2string(['W', 'o', 'n', 'd', 'e', 'r', 'f', 'u', 'l', 'l']) => "Wonderfull"</code></pre>
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
            Category::where('name', 'arrays')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/APqA4t8KNTBkgPq3DtWYnQWoPVDZ8hQ0DnXq7RQf.txt',
            'signature' => 'function arr2string($arr) {',
            'testClassName' => 'ArrayToString',
        ]);


        // Bit Inverter

        $slug = Str::slug('Bit Inverter');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Invert the Bits of a Given String.',
            'rank_id' => 2,
            'description' => <<<EOL
                <p>Create a function called <code>bit_inverter</code> that takes one argument: <code>strBin</code>. This is a string that represents a sequence of bits (0s and 1s). The function should return a new string that has the bits inverted (1s become 0s and 0s become 1s).</p>
                <p>For example, if the input string is <code>010</code>, the output string should be <code>101</code>.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>bit_inverter("010") => "101"</code></pre>
                <pre><code>bit_inverter("0110") => "1001"</code></pre>
                <pre><code>bit_inverter("0001") => "1110"</code></pre>
                <pre><code>bit_inverter("010101") => "101010"</code></pre>
                <pre><code>bit_inverter("000110101110") => "111001010001"</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/Ckss2SGJHxeZNcYYATzES41HaeWoQyevnjEe3tkv.txt',
            'signature' => 'function bit_inverter($strBin) {',
            'testClassName' => 'BitInverter',
        ]);



        // DecToBinBitwise

        $slug = Str::slug('Dec To Bin Bitwise');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Convert Decimal Number to Binary Using Bitwise Operator.',
            'rank_id' => 5,
            'description' => <<<EOL
                <p>Create a function called <code>decToBin</code> that takes one argument: <code>num</code>. This is an integer that represents a decimal number. The function should return a string that represents the binary equivalent of the decimal number.</p>
                <p>To convert a decimal number to binary, you can use the following steps:</p>
                <p>
                    <ul>
                        <li>Divide the number by 2 and get the remainder. This will be the rightmost bit of the binary number.</li>
                        <li>Divide the quotient by 2 and get the remainder. This will be the next bit of the binary number.</li>
                        <li>Repeat this process until the quotient is 0.</li>
                        <li>Write the remainders from bottom to top to get the binary number.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>decToBin(100) => "1100100"</code></pre>
                <pre><code>decToBin(1) => "1"</code></pre>
                <pre><code>decToBin(0) => "0"</code></pre>
                <pre><code>decToBin(5) => "101"</code></pre>
                <pre><code>decToBin(111068) => "11011000111011100"</code></pre>
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
            Category::where('name', 'algorithms')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/nPNSnlbIgxzF8NlOpVSDVPo1VjuWywjcvy55n9Ni.txt',
            'signature' => 'function decToBin($num) {',
            'testClassName' => 'DecToBinBitwise',
        ]);


        // LeapYear

        $slug = Str::slug('Leap Year');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Check Leap Year.',
            'rank_id' => 3,
            'description' => <<<EOL
                <p>Create a function called <code>leapYear</code> that takes one argument: <code>year</code>. This is an integer that represents a year. The function should return a boolean value that indicates whether the year is a leap year or not. A leap year is a year that has 366 days instead of 365 days, by adding an extra day to February</p>
                <p>To determine if a year is a leap year, you can use the following rules:</p>
                <p>
                    <ul>
                        <li>If the year is divisible by 4, it is a leap year, unless…</li>
                        <li>If the year is divisible by 100, it is not a leap year, unless…</li>
                        <li>If the year is divisible by 400, it is a leap year.</li>
                    </ul>
                </p>
                <p>For example, 2000 was a leap year because it was divisible by 400, but 2100 will not be a leap year because it will be divisible by 100 but not by 400.</p>
            EOL,
            'examples' => <<<EOL
                <pre><code>leapYear(1983) => false</code></pre>
                <pre><code>leapYear(2004) => true</code></pre>
                <pre><code>leapYear(2019) => false</code></pre>
                <pre><code>leapYear(2020) => true</code></pre>
                <pre><code>leapYear(2100) => false</code></pre>
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
            Category::where('name', 'dates')->first()->id,
            Category::where('name', 'algorithms')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/12dgGk17s7UeaOB1ZhkTVr7Iem8y0kY90Pab7Yfk.txt',
            'signature' => 'function leapYear($year) {',
            'testClassName' => 'LeapYear',
        ]);


        // Factorial

        $slug = Str::slug('Factorial Recursive');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Calculate the Factorial Given a Number Recursively',
            'rank_id' => 4,
            'description' => <<<EOL
                <p>Create a function called <code>factorial</code> that takes one argument: <code>num</code>. This is an integer that represents a number. The function should return the factorial of the number, which is the product of all positive integers less than or equal to the number.</p>
                <p>To calculate the factorial of a number, recursively, this is his base cases:</p>
                <p>
                    <ul>
                        <li>If the number is 0 or 1, the factorial is 1.</li>
                        <li>If the number is greater than 1, the factorial is the number multiplied by the factorial of the number minus one.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>factorial(5) => 120</code></pre>
                <pre><code>factorial(0) => 1</code></pre>
                <pre><code>factorial(1) => 1</code></pre>
                <pre><code>factorial(6) => 720</code></pre>
                <pre><code>factorial(10) => 3628800</code></pre>
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
            Category::where('name', 'recursion')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/9va76OJRyuOVNPdSySBfGEsAnafqvYQD1F7Zrm4O.txt',
            'signature' => 'function factorial($num) {',
            'testClassName' => 'Factorial',
        ]);


        // MCD

        $slug = Str::slug('Greatest Common Divisor');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Calculate the Greatest Common Divisor',
            'rank_id' => 3,
            'description' => <<<EOL
                <p>Write a function named <code>mcd</code> that takes two arguments of type <code>int</code> named <code>a</code> and <code>b</code> and returns the greatest common divisor (GCD/MCD) of them. The MCD of two numbers is the largest positive integer that divides both numbers without leaving a remainder. For example, the MCD of 12 and 18 is 6.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If both arguments are zero, return zero.</li>
                        <li>If one argument is zero and the other is not, return the absolute value of the non-zero argument.</li>
                        <li>0 <= a, b <= 10^9</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>mcd(0, 0) => 0</code></pre>
                <pre><code>mcd(1, 0) => 1</code></pre>
                <pre><code>mcd(0, 1) => 1</code></pre>
                <pre><code>mcd(2, 4) => 2</code></pre>
                <pre><code>mcd(3, 5) => 1</code></pre>
                <pre><code>mcd(6, 9) => 3</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/wrETHaLCjZCop45rmNdoB6zxvQSoMOgOKevftl84.txt',
            'signature' => 'function mcd($a, $b) {',
            'testClassName' => 'MCD',
        ]);


        // MCM

        $slug = Str::slug('Least Common Divisor');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Calculate the Least Common Divisor',
            'rank_id' => 3,
            'description' => <<<EOL
                <p>Write a function named <code>mcm</code> that takes two arguments of type <code>int</code> named <code>a</code> and <code>b</code> and returns the least common multiple (LCM) of them. The LCM of two numbers is the smallest positive integer that is divisible by both numbers without leaving a remainder. For example, the LCM of 4 and 6 is 12.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If both arguments are zero, return zero.</li>
                        <li>If one argument is zero and the other is not, return zero.</li>
                        <li>0 <= a, b <= 10^9</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>mcm(2, 3) => 6</code></pre>
                <pre><code>mcm(4, 6) => 12</code></pre>
                <pre><code>mcm(5, 10) => 10</code></pre>
                <pre><code>mcm(6, 8) => 24</code></pre>
                <pre><code>mcm(0, 0) => 0</code></pre>
                <pre><code>mcm(0, 1) => 0</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/bmVvtUyoNHbr6GZ1Ywr3gHZ9e9fwzyZO8ygD6u6O.txt',
            'signature' => 'function mcm($a, $b) {',
            'testClassName' => 'MCM',
        ]);


        // Fibonacci

        $slug = Str::slug('Fibonacci');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Generate the numbers of Fibonacci.',
            'rank_id' => 5,
            'description' => <<<EOL
                <p>Write a function named <code>fibonacci</code> that takes one argument of type <code>int</code> named <code>num</code> and returns an array of the Fibonacci sequence up to the given position. The Fibonacci sequence is a series of numbers where each number is the sum of the two preceding ones, starting from 0 and 1. For example, the first 10 numbers of the Fibonacci sequence are: 0, 1, 1, 2, 3, 5, 8, 13, 21, 34.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If the argument is zero, return an empty array.</li>
                        <li>If the argument is one, return an array with only 0.</li>
                        <li>If the argument is negative, throw an exception with the message “Invalid input”.</li>
                        <li>0 <= num <= 50</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>fibonacci(0) => []</code></pre>
                <pre><code>fibonacci(1) => [0]</code></pre>
                <pre><code>fibonacci(2) => [0, 1]</code></pre>
                <pre><code>fibonacci(3) => [0, 1, 1]</code></pre>
                <pre><code>fibonacci(4) => [0, 1, 1, 2]</code></pre>
                <pre><code>fibonacci(7) => [0, 1, 1, 2, 3, 5, 8]</code></pre>
                <pre><code>fibonacci(11) => [0 ,1 ,1 ,2 ,3 ,5 ,8 ,13 ,21 ,34 ,55]</code></pre>
            EOL,
            'notes' => <<<EOL
                <ul>
                    <li><b>Optional:</b> Try to solve it recursively.</li>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/IbBdN6riFJ3teSOzmmJYkrL3LubKyVFIna2iuRI2.txt',
            'signature' => 'function fibonacci($num) {',
            'testClassName' => 'Fibonacci',
        ]);


        // Trasposed Matrix

        $slug = Str::slug('Trasposed Matrix');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Get the Trasposed Matrix.',
            'rank_id' => 6,
            'description' => <<<EOL
                <p>Write a function named <code>trasposed</code> that takes one argument of type <code>array</code> named <code>matrix</code> and returns another array that represents the transpose of the given matrix. The transpose of a matrix is a new matrix whose rows are the columns of the original matrix. </p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If the argument is an empty array, return an empty array.</li>
                        <li>If the argument is one, return an array with only 0.</li>
                        <li>The given matrix can have any number of rows and columns.</li>
                        <li>It means that the past matrix will always be two-dimensional.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>trasposed([]) => []</code></pre>
                <pre><code>trasposed([]) => []</code></pre>
                <pre><code>trasposed([[1, 2], [3, 4]]) => [[1, 3], [2, 4]]</code></pre>
                <pre><code>trasposed([[1, 2, 3], [4, 5 ,6], [7 ,8 ,9]]) => [[1 ,4 ,7], [2 ,5 ,8], [3 ,6 ,9]]</code></pre>
                <pre><code>trasposed([[10 ,11 ,12], [13 ,14 ,15], [16 ,17 ,18]]) => [[10 ,13 ,16], [11 ,14 ,17], [12 ,15 ,18]]</code></pre>
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
            Category::where('name', 'arrays')->first()->id,
            Category::where('name', 'math')->first()->id,
            Category::where('name', 'algebra')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/CBYzLCAR2l0WC5SpQXlKsxXM8Tjm4KX847ik2vts.txt',
            'signature' => 'function trasposed($matrix) {',
            'testClassName' => 'TrasposedMatrix',
        ]);


        // Multiply Matrix

        $slug = Str::slug('Multiply Matrix');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Calculate the Multiply of Two Matrix.',
            'rank_id' => 6,
            'description' => <<<EOL
                <p>Write a function named <code>multiplied</code> that takes two arguments of type <code>array</code> named <code>matrixA</code> and <code>matrixB</code> and returns another array that represents the product of the two matrices.</p>
                <p>The product of two matrices is a new matrix whose elements are obtained by multiplying each row of the first matrix by each column of the second matrix and adding up the results.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If either argument is an empty array, return an empty array.</li>
                        <li>The given matrices can have any number of rows and columns.</li>
                        <li>It means that the past matrix will always be two-dimensional.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <p><code>multiplied([], []) => []</code></p>
                <p><code>multiplied([[1]], [[1]]) => [[1]]</code></p>
                <p><code>multiplied([[1, 2], [3, 4]], [[5, 6], [7, 8]])=> [[19, 22], [43, 50]]</code></p>
                <p><code>multiplied([[1 ,2 ,3], [4 ,5 ,6], [7 ,8 ,9]], [[10 ,11 ,12], [13 ,14 ,15], [16 ,17 ,18]]) => [[84 ,90 ,96], [201 ,216 ,231], [318 ,342 ,366]]</code></p>
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
            Category::where('name', 'arrays')->first()->id,
            Category::where('name', 'math')->first()->id,
            Category::where('name', 'algebra')->first()->id,
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/OS55Uj3N6sKLmKXfgjs7rkyEF17Bala9XAclQviY.txt',
            'signature' => 'function multiplied($matrixA, $matrixB) {',
            'testClassName' => 'MultiplyMatrix',
        ]);


        // CombinatorialNumbers

        $slug = Str::slug('Combinatorial Numbers');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Calculate the Combinatorial Number.',
            'rank_id' => 3,
            'description' => <<<EOL
                <p>Write a function named <code>combinatorial</code> that takes two arguments of type <code>int</code> named <code>m</code> and <code>n</code> and returns the binomial coefficient of them. The binomial coefficient of two numbers is the number of ways to choose n elements from a set of m elements without repetition and without regard to order.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If either argument is zero, return one.</li>
                        <li>0 <= m, n <= 20</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>combinatorial(3, 2) => 3</code></pre>
                <pre><code>combinatorial(8, 5) => 56</code></pre>
                <pre><code>combinatorial(5, 3) => 10</code></pre>
                <pre><code>combinatorial(10, 5) => 252</code></pre>
                <pre><code>combinatorial(4, 4) => 1</code></pre>
                <pre><code>combinatorial(0, 0) => 1</code></pre>
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
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/Pv8tGHJEqowUZhZtmSDpGWgMp0nPJYwING2fGlQY.txt',
            'signature' => 'function combinatorial($m, $n) {',
            'testClassName' => 'CombinatorialNumbers',
        ]);



        // PrimesBelowGivenNumber

        $slug = Str::slug('Primes Below Given Number');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Generate the Primes Below a Given Number.',
            'rank_id' => 2,
            'description' => <<<EOL
                <p>Write a function named <code>generatePrimes</code> that takes one argument of type <code>int</code> named <code>num</code> and returns an array of all the prime numbers between 2 and num (inclusive). A prime number is a natural number greater than 1 that has no positive divisors other than 1 and itself.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If the argument is less than 2, return an empty array.</li>
                        <li>0 <= num <= 1000</li>
                        <li>It means that the past number will always be a natural number.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>generatePrimes(7) => [2, 3, 5, 7]</code></pre>
                <pre><code>generatePrimes(10) => [2, 3, 5, 7]</code></pre>
                <pre><code>generatePrimes(20) => [2, 3, 5, 7, 11, 13, 17, 19]</code></pre>
                <pre><code>generatePrimes(1) => []</code></pre>
                <pre><code>generatePrimes(0) => []</code></pre>
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
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/YjzEMtkTXq7W16KGWKSfqWCt9C99didgKNYRBYwN.txt',
            'signature' => 'function generatePrimes($num) {',
            'testClassName' => 'PrimesBelowGivenNumber',
        ]);



        // IsPrime

        $slug = Str::slug('Is Prime');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Return if the number Is Prime.',
            'rank_id' => 2,
            'description' => <<<EOL
                <p>Write a function named <code>isPrime</code> that takes one argument of type <code>int</code> named <code>num</code> and returns a boolean value indicating whether the given number is a prime number or not. A prime number is a natural number greater than 1 that has no positive divisors other than 1 and itself.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If the argument is less than or equal to 1, return false.</li>
                        <li>0 <= num <= 1000</li>
                        <li>It means that the past number will always be a natural number.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>isPrime(2) => true</code></pre>
                <pre><code>isPrime(47) => true</code></pre>
                <pre><code>isPrime(215) => false</code></pre>
                <pre><code>isPrime(6) => false</code></pre>
                <pre><code>isPrime(7) => true</code></pre>
                <pre><code>isPrime(97) => true</code></pre>
                <pre><code>isPrime(100) => false</code></pre>
                <pre><code>isPrime(9) => false</code></pre>
                <pre><code>isPrime(11) => true</code></pre>
                <pre><code>isPrime(121) => false</code></pre>
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
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/ocnfVOgV1QwhiDVPFXyKtetOTL4cuNpwtSXEBIII.txt',
            'signature' => 'function isPrime($num) {',
            'testClassName' => 'IsPrime',
        ]);


        // StringSumDigit

        $slug = Str::slug('String Sum Digit');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Return the sum of the digits for a string',
            'rank_id' => 1,
            'description' => <<<EOL
                <p>Write a function named <code>sumDigit</code> that takes one argument of type <code>string</code> named <code>str</code> and returns the sum of the digits of the given string. The string represents a non-negative integer number.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If the argument is an empty string, return zero.</li>
                        <li>The length of the string is less than or equal to 1000</li>
                        <li>It means that the past string will always be with numerical format.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>sumDigit("123") => 6</code></pre>
                <pre><code>sumDigit("456") => 15</code></pre>
                <pre><code>sumDigit("789") => 24</code></pre>
                <pre><code>sumDigit("1010") => 2</code></pre>
                <pre><code>sumDigit("2468") => 20</code></pre>
                <pre><code>sumDigit("1357") => 16</code></pre>
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
            'mode_id' => $blitzModeID,
            'uri_test' => '/katas/php/pzaE8teLjE9qpoElQF3U4ANDTg9p2C4su39wOpec.txt',
            'signature' => 'function sumDigit($str) {',
            'testClassName' => 'StringSumDigit',
        ]);



        // PascalTriangle

        $slug = Str::slug('Pascal Triangle');

        $challenge = Challenge::create([
            'slug' => $slug,
            'url' => url("/katas/$slug"),
            'title' => 'Generate a row of Pascal’s triangle',
            'rank_id' => 7,
            'description' => <<<EOL
                <p>Write a function named <code>pascal</code> that takes one argument of type <code>int</code> named <code>num</code> and returns a string that represents the digits of the given row of Pascal’s triangle, separated by a space. Pascal’s triangle is a triangular array of numbers where each number is the sum of the two numbers above it. The rows and columns of Pascal’s triangle are numbered starting from 0.</p>
                <p><b>Base Case and Constrints</b></p>
                <p>
                    <ul>
                        <li>If the argument is zero, return “1”.</li>
                        <li>0 <= num <= 20</li>
                        <li>It means that the past number will always be a positive number.</li>
                    </ul>
                </p>
            EOL,
            'examples' => <<<EOL
                <pre><code>pascal(0) => "1"</code></pre>
                <pre><code>pascal(1) => "1 1"</code></pre>
                <pre><code>pascal(2) => "1 2 1"</code></pre>
                <pre><code>pascal(3) => "1 3 3 1"</code></pre>
                <pre><code>pascal(4) => "1 4 6 4 1"</code></pre>
                <pre><code>pascal(5) => "1 5 10 10 5 1"</code></pre>
                <pre><code>pascal(6) => "1 6 15 20 15 6 1"</code></pre>
                <pre><code>pascal(7) => "1 7 21 35 35 21 7 1"</code></pre>
                <pre><code>pascal(8) => "1 8 28 56 70 56 28 8 1""</code></pre>
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
        ];

        $challenge->categories()->sync($categories);

        $kata = Kata::create([
            'challenge_id' => $challenge->id,
            'owner_id' => $superadminID,
            'language_id' => $phpID,
            'mode_id' => $trainingModeID,
            'uri_test' => '/katas/php/VWdiyVmr1qRBksyIKuuHWWVpYTafiXpHeMtqDKtF.txt',
            'signature' => 'function pascal($num) {',
            'testClassName' => 'PascalTriangle',
        ]);


    }
}
