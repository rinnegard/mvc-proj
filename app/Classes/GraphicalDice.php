<?php

declare(strict_types=1);

namespace App\Classes;

class GraphicalDice extends Dice
{

    public function __construct()
    {
        parent::__construct(6);
    }

    public function getImageClass()
    {
        return "dice-" . $this->getFace();
    }
}
