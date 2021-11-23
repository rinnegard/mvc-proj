<?php

declare(strict_types=1);

namespace App\Classes;

use App\Classes\DiceHand;

class Yatzy
{
    public $playerDiceHand;
    private array $savedDice = [];
    private array $score = [];
    private int $throws = 0;
    private int $turn = 0;
    private ?int $totalScore = null;

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
                $this->playerDiceHand->removeDie(intval($key));
            }
        }

        if (isset($_POST["next"]) || $inp === "next") {
            $this->throws = 0;
            $this->calcScore();
            $this->playerDiceHand = new DiceHand(5);
            $this->savedDice = [];
            $this->turn++;
            if ($this->turn == 6) {
                $data["gameover"] = self::LOSEMESSAGE;
                array_push($this->score, array_sum($this->score));
                if ($this->score[6] >= 63) {
                    array_push($this->score, 50);
                }
                $this->totalScore = $this->score[6];
            }
        }

        return $data;
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
            if ($value == $this->turn + 1) {
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

    public function getTurn(): int
    {
        return $this->turn;
    }

    public function getThrows(): int
    {
        return $this->throws;
    }
}
