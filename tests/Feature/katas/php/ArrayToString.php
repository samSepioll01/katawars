<?php

use Tests\TestCase;

class ArrayToString extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_array_to_string($expected, $arr)
    {
        $this->assertEquals($expected, arr2string($arr));
    }

    public function provider()
    {
        return [
            ['Hello Folks!', ['H','e','l','l','o',' ','F','o','l','k','s','!']],
            ['Wonderfull', ['W', 'o', 'n', 'd', 'e', 'r', 'f', 'u', 'l', 'l']],
        ];
    }
}
