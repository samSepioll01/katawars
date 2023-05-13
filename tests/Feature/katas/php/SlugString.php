<?php

use Tests\TestCase;

class SlugString extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_reverse_string($str, $expected)
    {
        $this->assertEquals($expected, str_slug($str));
    }

    public function provider()
    {
        return [
            ['House of Cards', 'house-of-cards'],
            ['Game of Thrones', 'game-of-thrones'],
            ['Spiderman 2', 'spiderman-2'],
            ['info.email', 'info-email'],
            ['sandman_want_water', 'sandman-want-water'],
        ];
    }
}
