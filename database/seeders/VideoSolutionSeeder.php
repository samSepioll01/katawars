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
            'title' => 'VideoSolution 1',
            'youtube_code' => "<iframe width='560' height='315' src='https://www.youtube.com/embed/BRI8wqUMdao' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>",
            'kata_id' => 1,
        ]);

        VideoSolution::create([
            'title' => 'VideoSolution 2',
            'youtube_code' => "<iframe width='560' height='315' src='https://www.youtube.com/embed/fk6uS1Bq8mg' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>",
            'kata_id' => 2,
        ]);
    }
}
