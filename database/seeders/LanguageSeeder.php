<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'PHP',
            'extension' => '.php',
            'bg_color' => 'bg-gradient-to-tl from-indigo-600 to-violet-600',
            'uri_logo' => env('AWS_APP_URL') . '/languages/php.svg',
        ]);

        Language::create([
            'name' => 'Python',
            'extension' => '.py',
            'bg_color' => 'bg-gradient-to-br from-indigo-700 to-sky-600',
            'uri_logo' => env('AWS_APP_URL') . '/languages/python.png',
        ]);

        Language::create([
            'name' => 'Javascript',
            'extension' => '.js',
            'bg_color' => 'bg-gradient-to-br from-yellow-600 to-amber-400',
            'uri_logo' => env('AWS_APP_URL') . '/languages/js.svg',
        ]);
    }
}
