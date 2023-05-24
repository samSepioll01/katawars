<?php

use Tests\TestCase;

class ReverseString extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_reverse_string($expected, $str)
    {
        $this->assertEquals($expected, reverse($str));
    }

    public function provider()
    {
        return [
            [strrev('string'), 'string'],
            [strrev('katawars'), 'katawars'],
            [strrev('house'), 'house'],
            [strrev('donana'), 'donana'],
            [strrev('mistakes'), 'mistakes'],
        ];
    }
}
