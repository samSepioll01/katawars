<?php

namespace Tests\Feature\katas\php;
use Tests\TestCase;

class SumTwoNumbers extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_sum_two_numbers($a, $b, $expected)
    {
        $this->assertEquals($expected, sum($a, $b));
    }

    public function provider()
    {
        return [
            [1 ,2, 3],
            [2, 2, 4],
            [52, -5, 47],
            [7, 23, 30],
        ];
    }
}
