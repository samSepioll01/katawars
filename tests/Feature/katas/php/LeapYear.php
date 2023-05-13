<?php

use Tests\TestCase;

class LeapYear extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_leap_year($expected, $year)
    {
        $this->assertEquals($expected, leapYear($year));
    }

    public function provider()
    {
        return [
            [false, 1983],
            [false, 1987],
            [true, 2004],
            [true, 8],
            [true, 4],
            [false, 2019],
            [false,1970],
            [false,2021],
            [true,2020],
            [false,1874],
            [true,1968],
            [true,1980],
            [false,2100],
            [false,2200],
        ];
    }
}
