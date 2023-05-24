<?php

use Tests\TestCase;

class Palindrome extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testIsPalindrome($str, $expected)
    {
        $this->assertEquals($expected, isPalindrome($str));
    }

    public function additionProvider()
    {
        return [
            ['A man, a plan, a canal, Panama!', true],
            ['Was it a car or a cat I saw?', true],
            ['No \'x\' in Nixon', true],
            ['This is not a palindrome', false],
        ];
    }
}
