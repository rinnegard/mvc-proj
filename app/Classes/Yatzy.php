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
    private array $diceHistogram = [0, 0, 0, 0, 0, 0];
    private int $throws = 0;
    private int $turn = 0;
    private int $part1Counter = 0;
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
            // if ($this->turn <= 6) { //Testing on turn 1 && $this->turn > 1
            //     $this->calcScore();
            // }
            switch ($_POST["option"]) {
                case "ones":
                    $this->score[0] = $this->calcScore(1);
                    break;
                case "twoes":
                    $this->score[1] = $this->calcScore(2);
                    break;
                case "threes":
                    $this->score[2] = $this->calcScore(3);
                    break;
                case "fours":
                    $this->score[3] = $this->calcScore(4);
                    break;
                case "fives":
                    $this->score[4] = $this->calcScore(5);
                    break;
                case "sixes":
                    $this->score[5] = $this->calcScore(6);
                    break;
                case "one-pair":
                    $this->score[8] = $this->calcOnePair();
                    break;
                case "two-pair":
                    $this->score[9] = $this->calcTwoPair();
                    break;
                case "three-kind":
                    $this->score[10] = $this->calcThreeKind();
                    break;
                case "four-kind":
                    $this->score[11] = $this->calcFourKind();
                    break;
                case "full-house":
                    $this->score[12] = $this->calcFullHouse();
                    break;
                case "s-straight":
                    $this->score[13] = $this->calcSmallStraight();
                    break;
                case "l-straight":
                    $this->score[14] = $this->calcLargeStraight();
                    break;
                case "chance":
                    $this->score[15] = $this->calcChance();
                    break;
                case "yatzy":
                    $this->score[16] = $this->calcYatzy();
                    break;
                default:
                    break;
            }
            if ($this->part1Counter == 6) {
                $this->score[6] = 0;
                for ($i = 0; $i < 6; $i++) {
                    $this->score[6] += $this->score[$i];
                }
                if ($this->score[6] >= 63) {
                    $this->score[7] = 50;
                } else {
                    $this->score[7] = 0;
                }
                $this->part1Score = $this->score[6];
            }
            if ($this->turn == 15) {
                $this->calcTotalSum();
                $data["gameover"] = self::LOSEMESSAGE;
            }
            $this->playerDiceHand = new DiceHand(5);
            $this->savedDice = [];
            $this->savedDiceHand = [];
        }

        return $data;
    }

    public function calcTotalSum(): void
    {
        array_push($this->score, (array_sum($this->score) - $this->part1Score));
        $this->totalScore = $this->score[17];
    }


    public function calcOnePair(): int
    {
        $diceSum = 0;
        $len = count($this->savedDice);
        for ($i = 0; $i < $len - 1; $i++) {
            for ($j = $i + 1; $j < $len; $j++) {
                if ($this->savedDice[$i] == $this->savedDice[$j]) {
                    if ($diceSum < $this->savedDice[$i] * 2) {
                        $diceSum = intval($this->savedDice[$i]) * 2;
                    }
                }
            }
        }
        return $diceSum;
        // array_push($this->score, $diceSum);
    }

    public function calcTwoPair(): int
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
        return $diceSum;
    }

    public function calcThreeKind(): int
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        $key = array_key_first($arr);
        $value = array_shift($arr);
        if ($value >= 3) {
            $diceSum = $key * 3;
        }
        return $diceSum;
    }

    public function calcFourKind(): int
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        $key = arraY_key_first($arr);
        $value = array_shift($arr);
        if ($value >= 4) {
            $diceSum = $key * 4;
        }
        return $diceSum;
    }

    public function calcFullHouse(): int
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
        return $diceSum;
    }

    public function calcSmallStraight(): int
    {
        $diceSum = 0;
        $test = false;
        for ($i = 1; $i <= 5; $i++) {
            $test += in_array($i, $this->savedDice);
        }
        if ($test == 5) {
            $diceSum = 1 + 2 + 3 + 4 + 5;
        }
        return $diceSum;
    }

    public function calcLargeStraight(): int
    {
        $diceSum = 0;
        $test = false;
        for ($i = 2; $i <= 6; $i++) {
            $test += in_array($i, $this->savedDice);
        }
        if ($test == 5) {
            $diceSum = 2 + 3 + 4 + 5 + 6;
        }
        return $diceSum;
    }

    public function calcChance(): int
    {
        $diceSum = array_sum($this->savedDice);
        return $diceSum;
    }


    public function calcYatzy(): int
    {
        $diceSum = 0;
        $arr = array_count_values($this->savedDice);
        arsort($arr);
        $value = array_shift($arr);
        if ($value >= 5) {
            $diceSum = 50;
        }
        return $diceSum;
    }

    public function roll(): void
    {
        if ($this->throws < 3) {
            $this->throws++;
            $this->playerDiceHand->roll();
            foreach ($this->playerDiceHand->getAllDice() as $key => $value) {
                $value->getFace();
                switch ($value->getFace()) {
                    case 1:
                        $this->diceHistogram[0] += 1;
                        break;
                    case 2:
                        $this->diceHistogram[1] += 1;
                        break;
                    case 3:
                        $this->diceHistogram[2] += 1;
                        break;
                    case 4:
                        $this->diceHistogram[3] += 1;
                        break;
                    case 5:
                        $this->diceHistogram[4] += 1;
                        break;
                    case 6:
                        $this->diceHistogram[5] += 1;
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function getDiceHistogram(): array
    {
        return $this->diceHistogram;
    }

    public function calcScore($inp): int
    {
        $this->part1Counter += 1;
        $diceSum = 0;
        foreach ($this->savedDice as $value) {
            if ($value == $inp) {
                $diceSum = $diceSum + $value;
            }
        }
        return $diceSum;
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
