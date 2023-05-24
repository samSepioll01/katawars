<?php

namespace Tests\Feature\katas\php;

use Tests\TestCase;

class Ni extends TestCase
{
    public function test_say_ni()
    {
        $this->assertEquals('Ni!', say_ni());
    }
}
