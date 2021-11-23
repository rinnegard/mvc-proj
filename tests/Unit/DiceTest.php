<?php

declare(strict_types=1);

namespace App\Classes;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the Dice Class.
 */
class DiceTest extends TestCase
{

    public function testCreateDiceClass()
    {
        $dice = new Dice();
        $this->assertEquals(0, $dice->getFace());
    }

    public function testRollDice()
    {
        $dice = new Dice();
        $dice->roll();
        $this->assertGreaterThan(0, $dice->getFace());
    }
}
