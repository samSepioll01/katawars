<?php

use Tests\TestCase;

class PrimesBelowGivenNumber extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_primes_belowe_a_given_number($num, $expected)
    {
        $this->assertEquals($expected, generatePrimes($num));
    }

    public function provider()
    {
        return [
            [7, [2, 3, 5, 7]],
            [10, [2, 3, 5, 7]],
            [20, [2, 3, 5, 7, 11, 13, 17, 19]],
        ];
    }
}
