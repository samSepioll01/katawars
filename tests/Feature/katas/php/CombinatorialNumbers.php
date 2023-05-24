<?php

use Tests\TestCase;

class CombinatorialNumbers extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_combinatorial_numbers($m, $n, $expected)
    {
        $this->assertEquals($expected, combinatorial($m, $n));
    }

    public function provider()
    {
        return [
            [3, 2, 3], // C(3,2) = 3! / (2! * 1!) = 3
            [8, 5, 56], // C(4,4) = 4! / (4! * 0!) = 1
            [5, 3, 10], // C(5,3) = 5! / (3! * 2!) = 10
            [10, 5, 252] // C(10,5) = 10! / (5! * 5!) = 252
        ];
    }
}
