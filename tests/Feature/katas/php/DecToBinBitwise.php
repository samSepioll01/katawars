<?php

use Tests\TestCase;

class DecToBinBitwise extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_dec_to_bin_bitwise($expected, $num)
    {
        $this->assertEquals($expected, decToBin($num));
    }

    public function provider()
    {
        return [
            ['1100100', 100],
            ['1', 1],
            ['0', 0],
            ['101', 5],
            ['11011000111011100', 111068],
        ];
    }
}
