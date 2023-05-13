<?php

use Tests\TestCase;

class FootballPoints extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_football_points($expected, $res)
    {
        $this->assertEquals($expected, points($res[0], $res[1], $res[2]));
    }

    public function provider()
    {
        return [
            [13, [3, 4, 2]],
            [20, [5, 5, 5]],
            [3, [1, 0, 0]],
            [0, [0, 0, 15]],
            [7, [0, 7, 0]],
        ];
    }
}
