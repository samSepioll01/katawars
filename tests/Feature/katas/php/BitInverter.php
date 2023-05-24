<?php

use Tests\TestCase;

class BitInverter extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_bit_inverter($expected, $strBin)
    {
        $this->assertEquals($expected, bit_inverter($strBin));
    }

    public function provider()
    {
        return [
            ['101', '010'],
            ['1001', '0110'],
            ['1110', '0001'],
            ['101010', '010101'],
            ['111001010001', '000110101110'],
        ];
    }
}
