<?php

use Tests\TestCase;

class MultiplyMatrix extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_multiply_matrix($matrixA, $matrixB, $expected)
    {
        $this->assertEquals($expected, multiplied($matrixA, $matrixB));
    }

    public function provider()
    {
        return [
            // First test
            [
                // Matrix A
                [
                    [1, 2],
                    [3, 4]
                ],
                // Matrix B
                [
                    [5, 6],
                    [7, 8]
                ],
                // Expected Matrix
                [
                    [19, 22],
                    [43, 50]
                ]
            ],
            // Second test
            [
                // Matrix A
                [
                    [1, 0],
                    [0, 1]
                ],
                // Matrix B
                [
                    [9, 8],
                    [7, 6]
                ],
                // Expected Matrix
                [
                    [9, 8],
                    [7, 6]
                ]
            ],
            // Third test
            [
                // Matrix A
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]
                ],
                // Matrix B
                [
                    [10, 11, 12],
                    [13, 14, 15],
                    [16, 17, 18]
                ],
                // Expected Matrix
                [
                    [84, 90, 96],
                    [201, 216, 231],
                    [318, 342, 366]
                ]
            ],
            // Fouth test
            [
                // Matrix A
                [
                    [1, -2, 3],
                    [-4, 5, -6],
                    [7, -8, 9]
                ],
                // Matrix B
                [
                    [-9, 8, -7],
                    [6, -5, 4],
                    [-3, 2, -1]
                ],
                // Expected Matrix
                [
                    [-30, 24, -18],
                    [84, -69, 54],
                    [-138, 114, -90]
                ]
            ],
            // Fifth test
            [
                // Matrix A
                [
                    [1, 0, 0, 0 ,0],
                    [0 ,1 ,0 ,0 ,0],
                    [0 ,0 ,1 ,0 ,0],
                    [0 ,0 ,0 ,1 ,0],
                    [0 ,0 ,0 ,0 ,1]
                ],
                // Matrix B
                [
                    [2 ,4 ,6 ,8 ,10],
                    [12 ,14 ,16 ,18 ,20],
                    [22 ,24 ,26 ,28 ,30],
                    [32 ,34 ,36 ,38 ,40],
                    [42 ,44 ,46 ,48 ,50]
                ],
                // Expected Matrix
                [
                    [2 ,4 ,6 ,8 ,10],
                    [12 ,14 ,16 ,18 ,20],
                    [22 ,24 ,26 ,28 ,30],
                    [32 ,34 ,36 ,38 ,40],
                    [42 ,44 ,46 ,48 ,50]
                ]
            ]
        ];
    }
}
