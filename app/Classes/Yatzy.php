<?php

declare(strict_types=1);

namespace App\Classes;

use App\Classes\DiceHand;

class Yatzy
{
    public $playerDiceHand;
    private array $savedDiceHand = [];
    private array $savedDice = [];
    private array $score = [];
    private int $throws = 0;
    private int $turn = 0;
    private ?int $totalScore = null;
    private ?int $part1Score = null;

    const WINMESSAGE = "Time for the next round";
    const LOSEMESSAGE = "The game is over.";

    public function __construct(int $numberOfDie = 5)
    {
        $this->playerDiceHand = new DiceHand($numberOfDie);
    }

    public function play($inp = "doNothing"): array
    {
        $data = [
            "header" => "Play Yatzy!!",
            "message" => "Good luck!",
        ];

        if (isset($_POST["roll"]) || $inp === "roll") {
            $this->roll();
            if ($this->throws >= 3) {
                $data["roundEnd"] = self::WINMESSAGE;
            }
        }

        // $data["player"] = $this->playerDiceHand->getLastSum();

        if (isset($_POST["save"]) || $inp === "save") {
            if ($this->throws >= 3) {
                $data["roundEnd"] = self::WINMESSAGE;
            }
            unset($_POST["save"]);
            unset($_POST["_token"]);
            foreach ($_POST as $key => $value) {
                array_push($this->savedDice, $value);
                array_push($this->savedDiceHand, $this->playerDiceHand->getAllDice()[$key]);
                $this->playerDiceHand->removeDie(intval($key));
            }
        }

        if (isset($_POST["next"]) || $inp === "next") {
            $this->throws = 0;
            $this->turn++;
            //Testing on turn 1
            // if ($this->turn == 1) {
            //     $this->calcYatzy();
            // }
            if ($this->turn <= 6) { //Testing on turn 1 && $this->turn > 1
                $this->calcScore();
            }
            if ($this->turn == 6) {
                // $data["gameover"] = self::LOSEMESSAGE;
                array_push($this->score, array_sum($this->score));
                if ($this->score[6] >= 63) {
                    array_push($this->score, 50);
                } else {
                    array_push($this->score, 0);
                }
                $this->part1Score = $this->score[6];
            }
            switch ($this->turn) {
                case 7:
                    $this->calcOnePair();
                    break;
                case 8:
                    $this->calcTwoPair();
                    break;
                case 9:
                    $this->calcThreeKind();
                    break;
                case 10:
                    $this->calcFourKind();
                    break;
                case 11:
                    $this->calcFullHouse();
                    break;
                case 12:
                    $this->calcSmallStraight();
                    break;
                case 13:
                    $this->calcLargeStraight();
                    break;
                case 14:
                    $this->calcChance();
                    break;
                case 15:
                    $this->calcYatzy();
                    $this->calcTotalSum();
                    $data["gameover"] = self::LOSEMESSAGE;
                    break;
                default:
                    break;
            }
            $this->playerDiceHand = new DiceHand(5);
            $this->savedDice = [];
            $this->savedDiceHand = [];
        }

        return $data;
    }

    public function calcTotalSum()
    {
        array_push($this->score, (array_sum($this->score) - $this->part1Score));
        $this->totalScore = $this->score[17];
    }


    public function calcOnePair(): void
    {
        $diceSum = 0;
        $len = count($this->savedDice);
        for ($i=0; $i < $len-1; $i++) {
            for ($j=$i + 1; $j < $len; $j++) {
                if($this->savedDice[$i] == $this->savedDice[$j]) {
                    if ($diceSum < $this->savedDice[$i] * 2) {
                        $diceSum = intval($this->savedDice[$i]) * 2;
                    }
                }
            }
        }
        array_push($this->score, $diceSum);
    }

    public function calcTwoPair(): void
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        if (count($arr) == 2) {
            $sum1 = 0;
            $arr1 = array_slice($arr, 0, 1, true);
            $key1 = array_key_first($arr1);
            $value1 = array_shift($arr1);
            if ($value1 >= 2) {
                $sum1 = $key1 * 2;
            }
            $sum2 = 0;
            $arr2 = array_slice($arr, 1, 1, true);
            $key2 = array_key_first($arr2);
            $value2 = array_shift($arr2);
            if ($value2 >= 2) {
                $sum2 = $key2 * 2;
            }
            $diceSum = $sum1 + $sum2;
        }
        array_push($this->score, $diceSum);

    }

    public function calcThreeKind(): void
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        $key = array_key_first($arr);
        $value = array_shift($arr);
        if ($value >= 3) {
            $diceSum = $key * 3;
        }
        array_push($this->score, $diceSum);
    }

    public function calcFourKind(): void
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        $key = arraY_key_first($arr);
        $value = array_shift($arr);
        if ($value >= 4) {
            $diceSum = $key * 4;
        }
        array_push($this->score, $diceSum);
    }

    public function calcFullHouse(): void
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        if (count($arr) == 2) {
            $sum1 = 0;
            $arr1 = array_slice($arr, 0, 1, true);
            $key1 = array_key_first($arr1);
            $value1 = array_shift($arr1);
            if ($value1 >= 2) {
                $sum1 = $key1 * $value1;
            }
            $sum2 = 0;
            $arr2 = array_slice($arr, 1, 1, true);
            $key2 = array_key_first($arr2);
            $value2 = array_shift($arr2);
            if ($value2 >= 2) {
                $sum2 = $key2 * $value2;
            }
            $diceSum = $sum1 + $sum2;
        }
        array_push($this->score, $diceSum);
    }

    public function calcSmallStraight(): void
    {
        $diceSum = 0;
        $test = false;
        for ($i=1; $i <= 5 ; $i++) {
            $test += in_array($i, $this->savedDice);
        }
        if ($test == 5) {
            $diceSum = 1 + 2 + 3 + 4 + 5;
        }
        array_push($this->score, $diceSum);
    }

    public function calcLargeStraight(): void
    {
        $diceSum = 0;
        $test = false;
        for ($i=2; $i <= 6 ; $i++) {
            $test += in_array($i, $this->savedDice);
        }
        if ($test == 5) {
            $diceSum = 2 + 3 + 4 + 5 + 6;
        }
        array_push($this->score, $diceSum);
    }

    public function calcChance(): void
    {
        $diceSum = array_sum($this->savedDice);
        array_push($this->score, $diceSum);
    }


    public function calcYatzy(): void
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        $key = arraY_key_first($arr);
        $value = array_shift($arr);
        if ($value >= 5) {
            $diceSum = $key * 5;
        }
        array_push($this->score, $diceSum);
    }

    public function roll(): void
    {
        if ($this->throws < 3) {
            $this->throws++;
            $this->playerDiceHand->roll();
        }
    }

    public function calcScore(): void
    {
        $diceSum = 0;
        foreach ($this->savedDice as $value) {
            if ($value == $this->turn) {
                $diceSum = $diceSum + $value;
            }
        }
        array_push($this->score, $diceSum);
    }

    public function setScore($score): void
    {
        $this->score = $score;
    }

    public function getScore(): array
    {
        return $this->score;
    }

    public function setTotalScore($totalScore): void
    {
        $this->totalScore = $totalScore;
    }

    public function getTotalScore(): ?int
    {
        return $this->totalScore;
    }

    public function show()
    {
        return $this->playerDiceHand->getAllDice();
    }

    public function showSaved(): string
    {
        return json_encode($this->savedDice);
    }

    public function getSavedDiceHand(): array
    {

        return $this->savedDiceHand;
    }

    public function getTurn(): int
    {
        return $this->turn;
    }

    public function getThrows(): int
    {
        return $this->throws;
    }
}
