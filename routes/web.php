<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YatzyController;
use App\Http\Controllers\HighscoreController;
use App\Http\Controllers\HelloController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HelloController::class, 'start'])->name("hello");
Route::post('/', [HelloController::class, 'startGame']);

Route::get('/yatzy', [YatzyController::class, 'start'])->name("yatzy");
Route::post('/yatzy', [YatzyController::class, 'run'])->name("yatzyPost");

Route::get('yatsy/highscore', [HighscoreController::class, 'start'])->name("highscore");
