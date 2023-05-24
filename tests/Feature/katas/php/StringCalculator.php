<?php

use Tests\TestCase;

class StringCalculator extends TestCase
{
    /**
    * @dataProvider provider
    */
    public function test_string_calculator($expected, $delimiter, $str)
    {
        $this->assertEquals($expected, str_calc($delimiter, $str));
    }

    public function provider()
    {
        return [
            [7, ',', '3,4'],
            [34, ',', '14,20'],
            [2205, ':', '1956:249'],
            [2, '-', '1-1'],
            [0, ',', '0,0'],
            [9, ";", "a;2;b;3;c;4"],
        ];
    }
}
