<?php

use Tests\TestCase;

class TennisMatch extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_tennis_score($expected, $pointsP1, $pointsP2)
    {
        $this->assertEquals($expected, scoreTo($pointsP1, $pointsP2));
    }

    public function provider()
    {
        return [
            ['love all', 0, 0],
            ['fifteen love', 15, 0],
            ['thirty love', 30, 0],
            ['forty love', 40, 0],
            ['love fifteen', 0, 15],
            ['love thirty', 0, 30],
            ['love forty', 0, 40],
            ['fifteen all', 15, 15],
            ['fifteen thirty', 15, 30],
            ['fifteen forty', 15, 40],
            ['thirty fifteen', 30, 15],
            ['forty fifteen', 40, 15],
            ['thirty all', 30, 30],
            ['forty thirty', 40, 30],
            ['thirty forty', 30, 40],
            ['deuce', 40, 40],
            ['adventage player 1', 'A', 40],
            ['adventage player 2', 40, 'A'],
        ];
    }
}
