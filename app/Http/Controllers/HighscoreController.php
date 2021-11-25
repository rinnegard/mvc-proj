<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Yatzy as YatzyModel;

class HighscoreController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function start()
    {
        $highscore = YatzyModel::all()->sortByDesc("score");
        return view("highscore", ["highscore" => $highscore]);
    }

    public function search(Request $request)
    {
        $search = $request->post('search');
        $highscore = YatzyModel::where('name', "like", "%{$search}%")->get()->sortByDesc("score");
        return view("highscore", ["highscore" => $highscore, "posted" => $search]);
    }
}
