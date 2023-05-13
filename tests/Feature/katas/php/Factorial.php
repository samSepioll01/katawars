<?php

use Tests\TestCase;

class Factorial extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_factorial_iterative($expected, $num)
    {
        $this->assertEquals($expected, factorial($num));
    }

    public function provider()
    {
        return [
            [120, 5],
            [1, 0],
            [1, 1],
            [2, 2],
            [6, 3],
            [720, 6],
            [3628800, 10],
            [5040, 7],
        ];
    }
}
