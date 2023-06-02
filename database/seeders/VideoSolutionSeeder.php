<?php

namespace Database\Seeders;

use App\Models\VideoSolution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VideoSolution::create([
            'title' => 'FizzBuzz Video Solution',
            'youtube_code' => '<iframe width="340" height="220" src="https://www.youtube.com/embed/hVlRSdIL2P8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'kata_id' => 8,
        ]);

        VideoSolution::create([
            'title' => 'Recursive Factorial Video Solution',
            'youtube_code' => '<iframe width="340" height="220" src="https://www.youtube.com/embed/_CybtB6iRbE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'kata_id' => 22,
        ]);

        VideoSolution::create([
            'title' => 'Fibonnacci Video Solution',
            'youtube_code' => '<iframe width="340" height="220" src="https://www.youtube.com/embed/2WOJWN695wU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'kata_id' => 25,
        ]);

        VideoSolution::create([
            'title' => 'Palindrome String Video Solution',
            'youtube_code' => '<iframe width="340" height="220" src="https://www.youtube.com/embed/ozryDqb4UAU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'kata_id' => 14,
        ]);
    }
}
