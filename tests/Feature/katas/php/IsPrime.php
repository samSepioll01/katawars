<?php

use Tests\TestCase;

class IsPrime extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_is_prime($num, $expected)
    {
        $this->assertEquals($expected, isPrime($num));
    }

    public function provider()
    {
        return [
            [2, true],
            [47, true],
            [215, false],
            [6, false],
            [7, true],
            [97, true],
            [100, false],
            [9, false],
            [11, true],
            [121, false],
        ];
    }
}
