<?php

use Tests\TestCase;

class MCD extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_mcd($a, $b, $expected)
    {
        $this->assertEquals($expected, mcd($a, $b));
    }

    public function provider()
    {
        return [
            [0, 0, 0],
            [1, 0, 1],
            [0, 1, 1],
            [1, 1, 1],
            [2, 2, 2],
            [2, 4, 2],
            [3, 5, 1],
            [6, 9, 3],
        ];
    }
}
