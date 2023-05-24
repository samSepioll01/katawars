<?php

use Tests\TestCase;

class CountSubstring extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_sount_substring($expected, $haystack, $needle)
    {
        $this->assertEquals($expected, count_str($haystack, $needle));
    }

    public function provider()
    {
        return [
            [2, 'The Knights Of ni never lose', 'ni'],
            [2, 'Willy Wonka on fire', 'on'],
            [0, 'Alice in Wonderland', 'fly'],
            [4, 'The Caesar Palace theatre have the best show in the world', 'the'],
        ];
    }
}
