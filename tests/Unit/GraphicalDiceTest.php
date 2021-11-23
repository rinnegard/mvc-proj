<?php

declare(strict_types=1);

namespace App\Classes;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the Dice Class.
 */
class GraphicalDiceTest extends TestCase
{

    public function testGetImageClass()
    {
        $dice = new GraphicalDice();
        $this->assertStringContainsString("dice-", $dice->getImageClass());
    }
}
