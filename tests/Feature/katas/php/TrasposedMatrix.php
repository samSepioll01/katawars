<?php

use Tests\TestCase;

class TrasposedMatrix extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_trasposed_matrix($matrix, $expected)
    {
        $this->assertEquals($expected, trasposed($matrix));
    }

    public function provider()
    {
        return [
            // First test
            [
                // Original Matrix
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]
                ],
                // Expected Trasposed Matrix
                [
                    [1, 4, 7],
                    [2, 5, 8],
                    [3, 6, 9]
                ]
            ],
            // Second test
            [
                // Original Matrix
                [
                    [10, 11, 12],
                    [13, 14, 15],
                    [16, 17, 18]
                ],
                // Expected Trasposed Matrix
                [
                    [10, 13, 16],
                    [11, 14, 17],
                    [12, 15, 18]
                ]
            ]
        ];
    }
}
