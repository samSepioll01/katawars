<?php

use Tests\TestCase;

class ArrayFiltered extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_array_filtered($expected, $arr, $num)
    {
        $this->assertEquals($expected, filtered($arr, $num));
    }

    public function provider()
    {
        return [
            [[], range(1,7), 7],
            [[1544, 12, 2], [-53, 1544, 12, 0, -511, 2], 0],
            [[1,2,3,4,5], [1,2,3,4,5], 0],
            [[-50, 0, 1], [-200, -50, 0, 1], -100],
        ];
    }
}
