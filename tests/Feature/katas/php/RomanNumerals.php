<?php

use Tests\TestCase;

class RomanNumerals extends TestCase
{
    /**
     * @dataProvider checks
     */
    public function test_generates_the_roman_numeral_for($number, $numeral)
    {
        $this->assertEquals($numeral, generate($number));
    }

    public function checks()
    {
        return [
            [1, 'I'],
            [2, 'II'],
            [3, 'III'],
            [4, 'IV'],
            [5, 'V'],
            [6, 'VI'],
            [7, 'VII'],
            [8, 'VIII'],
            [9, 'IX'],
            [10, 'X'],
            [40, 'XL'],
            [50, 'L'],
            [90, 'XC'],
            [100, 'C'],
            [400, 'CD'],
            [500, 'D'],
            [900, 'CM'],
            [1000, 'M'],
            [3999, 'MMMCMXCIX'],
            [2023, 'MMXXIII'],
            [4000, ''],
        ];
    }
}
