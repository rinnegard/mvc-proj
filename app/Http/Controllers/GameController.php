<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Classes\Dice;
use App\Classes\DiceHand;
use App\Classes\Yatzy;

class GameController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function start()
    {
        $dice = app()->make(Dice::class);
        $dice->roll();
        return view("game21", ["dice" => $dice->getFace()]);
    }
}
