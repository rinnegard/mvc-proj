<?php
declare(strict_types=1);

namespace App\Classes;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the Dice Class.
 */
class YatzyTest extends TestCase
{
    public function testYatzyClass()
    {
        $yatzy = new Yatzy();
        $this->assertInstanceOf("App\Classes\Yatzy", $yatzy);
    }

    public function testYatzyPlayRoll()
    {
        $yatzy = new Yatzy();
        for ($i = 0; $i < 3; $i++) {
            $data = $yatzy->play("roll");
        }
        $this->assertGreaterThan(0, $yatzy->playerDiceHand->getLastSum());
        $this->assertArrayHasKey("roundEnd", $data);
    }

    public function testYatzyPlaySave()
    {
        $yatzy = new Yatzy();
        for ($i = 0; $i < 3; $i++) {
            $data = $yatzy->play("roll");
        }
        $data = $yatzy->play("save");
        $this->assertArrayHasKey("roundEnd", $data);
    }

    public function testYatzyPlayNext()
    {
        $yatzy = new Yatzy();
        for ($i = 0; $i < 2; $i++) {
            $yatzy->play("roll");
        }
        $this->assertEmpty($yatzy->getScore());
        $this->assertEquals(2, $yatzy->getThrows());
        $yatzy->play("next");
        $this->assertEquals(0, $yatzy->getThrows());
        $this->assertNotEmpty($yatzy->getScore());
        $this->assertequals(1, $yatzy->getTurn());
        for ($i = 0; $i < 4; $i++) {
            $data = $yatzy->play("next");
        }
        $yatzy->setScore([20, 20, 20, 20, 20]);
        $data = $yatzy->play("next");
        $this->assertArrayHasKey("gameover", $data);
        $this->assertEquals(50, $yatzy->getScore()[7]);
    }

    public function testYatzyShow()
    {
        $yatzy = new Yatzy();

        $dicehand = $yatzy->show();
        $this->assertIsArray($dicehand);
        $dicehand[2]->roll();
        $this->assertGreaterThan(0, $dicehand[2]->getFace());
    }

    public function testYatzyShowSaved()
    {
        $yatzy = new Yatzy();

        $dicehand = $yatzy->showSaved();
        $this->assertIsString($dicehand);
    }


    public function testYatzySaveDice()
    {

        $_POST[2] = 2;
        $yatzy = new Yatzy();
        $yatzy->play("roll");
        $before = count($yatzy->playerDiceHand->getAllDice());
        $data = $yatzy->play("save");
        $after = count($yatzy->playerDiceHand->getAllDice());
        $this->assertEquals(1, $before - $after);
    }
}
