<?php

use Tests\TestCase;

class BowlingScore extends TestCase
{
    /**
     * @dataProvider scoresProvider
     */
    public function test_scores_bowling_game($expected, $rolls)
    {
        $this->assertSame($expected, bowling_score($rolls));
    }

    public function scoresProvider()
    {
        return [

            [300, array_fill(0, 12, 10)],
            [150, array_fill(0, 21, 5)],
            [80, array_fill(0, 20, 4)],
            [200, [10, 5, 5, 10, 5, 5, 10, 5, 5, 10, 5, 5, 10, 5, 5, 10]],
            [194, [10, 0, 10, 7, 2, 10, 10, 10, 8, 2, 9, 1, 7, 2, 10, 10, 5]],
            [177, [8, 0, 8, 2, 10, 10, 7, 3, 9, 1, 7, 2, 10, 10, 9, 0]],
        ];
    }
}
