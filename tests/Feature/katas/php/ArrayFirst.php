<?php

use Tests\TestCase;

class ArrayFirst extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_first_first($expected, $arr)
    {
        $this->assertEquals($expected, array_first($arr));
    }

    public function provider()
    {
        return [
            ['Lancelot', ['Lancelot', 'Dartagnan', 'Alatriste']],
            ['Venom', ['Venom', 'Sandman', 'Octopus', 'Kindpin']],
            ['Spain', ['Spain', 'Croatia', 'USA', 'New Zeland']],
            ['PHP', ['PHP', 'C', 'Javascript', 'Python']],
        ];
    }
}
