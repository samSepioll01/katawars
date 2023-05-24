<?php

use Tests\TestCase;

class Fibonacci extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_fibonacci($num, $expected)
    {
        $this->assertEquals($expected, fibonacci($num));
    }

    public function provider()
    {
        return [
            [0, []],
            [1, [0]],
            [2, [0, 1]],
            [3, [0, 1, 1]],
            [4, [0, 1, 1, 2]],
            [5, [0, 1, 1, 2, 3]],
            [6, [0, 1, 1, 2, 3, 5]],
            [7, [0, 1, 1, 2, 3, 5, 8]],
            [8, [0, 1, 1, 2, 3, 5, 8, 13]],
            [9, [0, 1, 1, 2, 3, 5, 8, 13, 21]],
            [10, [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]],
            [11, [0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55]],
        ];
    }
}
