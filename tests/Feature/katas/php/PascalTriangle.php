<?php

namespace Tests\Feature\katas\php;

use Tests\TestCase;

class PascalTriangle extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_pascal_triangle($num, $expected)
    {
        $this->assertEquals($expected, pascal($num));
    }

    public function provider()
    {
        return [
            [0, "1"],
            [1, "1 1"],
            [2, "1 2 1"],
            [3, "1 3 3 1"],
            [4, "1 4 6 4 1"],
            [5, "1 5 10 10 5 1"],
            [6, "1 6 15 20 15 6 1"],
            [7, "1 7 21 35 35 21 7 1"],
            [8, "1 8 28 56 70 56 28 8 1"],
            [9, "1 9 36 84 126 126 84 36 9 1"],
        ];
    }
}
