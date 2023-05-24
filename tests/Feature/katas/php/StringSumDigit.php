<?php

use Tests\TestCase;

class StringSumDigit extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_string_sum_digit($str, $expected)
    {
        $this->assertEquals($expected, sumDigit($str));
    }

    public function provider()
    {
        return [
            ["123", 6],
            ["456", 15],
            ["789", 24],
            ["1010", 2],
            ["2468", 20],
            ["1357", 16],
            ["9999", 36],
            ["0000", 0],
            ["1111", 4],
            ["54321", 15],
        ];
    }
}
