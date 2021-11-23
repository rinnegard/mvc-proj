<?php

declare(strict_types=1);

namespace App\Classes;

class DiceHand
{
    private int $numberOfDie;
    private int $lastSum = 0;
    private array $dice;

    public function __construct(int $numberOfDie = 1)
    {
        $this->numberOfDie = $numberOfDie;
        for ($i = 0; $i < $numberOfDie; $i++) {
            $this->dice[$i] = new Dice(6);
        }
    }

    public function roll(): void
    {
        $this->dice = array_values($this->dice);
        $this->lastSum = 0;
        $count = count($this->dice);
        for ($i = 0; $i < $count; $i++) {
            $this->dice[$i]->roll();
            $this->lastSum += $this->dice[$i]->getFace();
        }
    }

    public function getLastSum(): int
    {
        return $this->lastSum;
    }

    public function getNumOfDie(): int
    {
        return $this->numberOfDie;
    }

    // public function rollOnlyOne(int $die): void
    // {
    //     $this->dice[$die]->roll();
    // }

    // public function getDie(int $die): object
    // {
    //     return $this->dice[$die];
    // }

    public function getAllDice(): array
    {
        return $this->dice;
    }

    public function removeDie(int $die): void
    {
        unset($this->dice[$die]);
    }
}
