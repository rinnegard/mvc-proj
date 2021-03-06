<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Classes\Yatzy;
use App\Models\Yatzy as YatzyModel;

class YatzyController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function start(Request $request)
    {
        $data = [
            "header" => "Play Yatzy!!",
            "message" => "Let's play!",
        ];
        $yatzy = app()->make(Yatzy::class);
        $request->session()->put('yatzy', $yatzy);
        return view("yatzy", $data);
    }

    public function run(Request $request)
    {
        $yatsy = $request->session()->get('yatzy');
        $data = $yatsy->play();
        if (null !== $yatsy->getTotalScore()) {
            $yatzyModel = new YatzyModel();
            // @phpstan-ignore-next-line
            $yatzyModel->score = $yatsy->getTotalScore();
            // @phpstan-ignore-next-line
            $yatzyModel->name = $request->session()->get('name') ?? "Anonymous";
            // @phpstan-ignore-next-line
            $yatzyModel->histogram = json_encode($yatsy->getDiceHistogram());
            $yatzyModel->save();
        }
        return view("yatzy", $data);
    }
}
