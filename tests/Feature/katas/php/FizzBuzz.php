<?php

use Tests\TestCase;

class FizzBuzz extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_fizz_buzz($expected, $number)
    {
        $this->assertEquals($expected, fizzbuzz($number));
    }

    public function provider()
    {
        return [
            ['Fizz', 3],
            ['Buzz', 5],
            ['Buzz', 10],
            ['FizzBuzz', 15],
            [2, 2],
            ['FizzBuzz',75]
        ];
    }
}
