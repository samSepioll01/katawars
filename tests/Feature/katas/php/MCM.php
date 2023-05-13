<?php

use Tests\TestCase;

class MCM extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_mcm($a, $b, $expected)
    {
        $this->assertEquals($expected, mcm($a, $b));
    }

    public function provider()
    {
        return [
            [2, 3, 6],
            [4, 6, 12],
            [5, 10, 10],
            [6, 8, 24],
        ];
    }
}
