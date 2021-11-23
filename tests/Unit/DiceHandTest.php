<?php

declare(strict_types=1);

namespace App\Classes;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the Dice Class.
 */
class DiceHandTest extends TestCase
{

    public function testCreateDiceClass()
    {
        $dicehand = new DiceHand();
        $this->assertIsArray($dicehand->getAllDice());
    }

    public function testRollDice()
    {
        $dicehand = new DiceHand(6);
        $dicehand->roll();
        $this->assertGreaterThan(6, $dicehand->getLastSum());
    }

    public function testGetNumOfDie()
    {
        $dicehand = new DiceHand(10);
        $this->assertEquals(10, $dicehand->getNumOfDie());
    }

    public function testRemoveDie()
    {
        $dicehand = new DiceHand(10);
        $dicehand->removeDie(5);
        $this->assertEquals(9, count($dicehand->getAllDice()));
    }
}
