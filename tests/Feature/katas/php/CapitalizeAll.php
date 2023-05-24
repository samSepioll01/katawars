<?php

use Tests\TestCase;

class CapitalizeAll extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_capitalize_all($expected, $str)
    {
        $this->assertEquals($expected, capitalize_all($str));
    }

    public function provider()
    {
        return [
            ['Hello World', 'hello world'],
            ['Katawars Is Great', 'katawars is great'],
            ['In A Site Of La Mancha...', 'in a site of la mancha...'],
            ['Kobe Bryant', 'kobe bryant'],
            ['Alice Throught The Mirror', 'alice throught the mirror'],
        ];
    }
}
