<?php

namespace Tests\Feature\katas\php;
use Tests\TestCase;

class PrimeFactors extends TestCase
{
    /**
     * @dataProvider factors
     */
    public function test_generates_prime_factors_for($number, $expected)
    {
        $this->assertEquals($expected, prime_factors($number));
    }

    public function factors()
    {
        return [
            [1 , []],
            [2, [2]],
            [3, [3]],
            [4, [2, 2]],
            [5, [5]],
            [6, [2, 3]],
            [7, [7]],
            [8, [2, 2, 2]],
            [100, [2, 2, 5, 5]]
        ];
    }
}
