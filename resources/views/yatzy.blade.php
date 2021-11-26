@extends("layouts.basic")

@section("content")
<?php

$header = $header ?? null;
$message = $message ?? null;


$die1 = Session::get('yatzy')->show();
$savedDie = Session::get('yatzy')->showSaved();
$savedDiceHand = Session::get('yatzy')->getSavedDiceHand();
$turn = Session::get('yatzy')->getTurn();
$throws = Session::get('yatzy')->getThrows();
$score = Session::get('yatzy')->getScore();
$histogram = Session::get('yatzy')->getDiceHistogram();
$name = Session::get('name');


?>
<div class="game">
    <h1><?= $header ?></h1>
    <p><?= $message ?></p>

    <?php if (!isset($gameover)) : ?>
        <p>Select the dice you want to save.</p>
        <p>
            <form  action="" method="post">
                @csrf
                <?php foreach ($die1 as $key => $value) : ?>
                <label>
                <input type="checkbox" name="<?= $key ?>" value="<?= $value->getFace() ?>">
                    <i class="fas fa-dice-{{ $value->getFaceString() }} fa-3x"></i>
                </input>
                </label>
                <?php endforeach; ?>
                <input class="button" type="submit" name="save" value="Save">
            </form>
        </p>

        <p>You have <?= 3 - $throws ?> throws remaining</p>

        <?php if (!isset($roundEnd)) : ?>
            <form  action="" method="post">
                @csrf
                <input class="button" type="submit" name="roll" value="Roll!">
            </form>
        <?php endif; ?>
        <?php if (isset($roundEnd)) : ?>
            <p></p>
            <form  action="" method="post">
                @csrf
                <select name="option" required >
                    @if (!isset($score[0]))
                        <option value="ones">Ones</option>
                    @endif
                    @if (!isset($score[1]))
                        <option value="twoes">Twoes</option>
                    @endif
                    @if (!isset($score[2]))
                        <option value="threes">Threes</option>
                    @endif
                    @if (!isset($score[3]))
                        <option value="fours">Fours</option>
                    @endif
                    @if (!isset($score[4]))
                        <option value="fives">Fives</option>
                    @endif
                    @if (!isset($score[5]))
                        <option value="sixes">Sixes</option>
                    @endif
                    @if (!isset($score[8]))
                        <option value="one-pair">One Pair</option>
                    @endif
                    @if (!isset($score[9]))
                        <option value="two-pair">Two Pair</option>
                    @endif
                    @if (!isset($score[10]))
                        <option value="three-kind">Three of a kind</option>
                    @endif
                    @if (!isset($score[11]))
                        <option value="four-kind">Four of a kind</option>
                    @endif
                    @if (!isset($score[12]))
                        <option value="full-house">Full house</option>
                    @endif
                    @if (!isset($score[13]))
                        <option value="s-straight">Small Straight</option>
                    @endif
                    @if (!isset($score[14]))
                        <option value="l-straight">Large Straight</option>
                    @endif
                    @if (!isset($score[15]))
                        <option value="chance">Chance</option>
                    @endif
                    @if (!isset($score[16]))
                        <option value="yatzy">Yatzy</option>
                    @endif
                </select>
                <input class="button" type="submit" name="next" value="Next Round">
            </form>
            <p><?= $roundEnd ?></p>
        <?php endif; ?>
        <h3>Saved Dice:</h3>
        <p>
            @foreach ($savedDiceHand as $key => $value)
                <i class="fas fa-dice-{{ $value->getFaceString() }} fa-3x"></i>
            @endforeach
        </p>
    <?php endif; ?>
    <table>
        <caption>Dice Histogram</caption>
        <tr>
            <th>Dice</th>
            @foreach ($histogram as $key => $value)
            <td>{{ $key + 1 }}</td>
            @endforeach
        </tr>

        <tr>
            <th>Count</th>
            @foreach ($histogram as $key => $value)
            <td>{{ $value }}</td>
            @endforeach
        </tr>

    </table>
    <?php if (isset($gameover)) : ?>
        <p><?= $gameover ?></p>
    <?php endif; ?>
</div>
<table>
    <caption>Scoreboard</caption>
    <tr>
        <th>Player</th>
        <td>{{ $name }}</td>
    </tr>
    <tbody class="yatzy-1">
        <tr
            <?php if ($turn == 0) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Ones</td>
            <?php if (isset($score[0])) : ?>
                <td><?= $score[0] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 1) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Twoes</td>
            <?php if (isset($score[1])) : ?>
                <td><?= $score[1] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 2) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Threes</td>
            <?php if (isset($score[2])) : ?>
                <td><?= $score[2] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 3) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Fours</td>
            <?php if (isset($score[3])) : ?>
                <td><?= $score[3] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 4) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Fives</td>
            <?php if (isset($score[4])) : ?>
                <td><?= $score[4] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 5) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Sixes</td>
            <?php if (isset($score[5])) : ?>
                <td><?= $score[5] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 6) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Sum</td>
            <?php if (isset($score[6])) : ?>
                <td><?= $score[6] ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td>Bonus</td>
            <?php if (isset($score[7])) : ?>
                <td><?= $score[7] ?></td>
            <?php endif; ?>
        </tr>
    </tbody>
    <tbody>
        <tr
            <?php if ($turn == 7) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>One Pair</td>
            <?php if (isset($score[8])) : ?>
                <td><?= $score[8] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 8) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Two Pair</td>
            <?php if (isset($score[9])) : ?>
                <td><?= $score[9] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 9) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Three of a kind</td>
            <?php if (isset($score[10])) : ?>
                <td><?= $score[10] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 10) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Four of a kind</td>
            <?php if (isset($score[11])) : ?>
                <td><?= $score[11] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 11) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Full house</td>
            <?php if (isset($score[12])) : ?>
                <td><?= $score[12] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 12) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Small straight</td>
            <?php if (isset($score[13])) : ?>
                <td><?= $score[13] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 13) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Large straight</td>
            <?php if (isset($score[14])) : ?>
                <td><?= $score[14] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 14) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Chance</td>
            <?php if (isset($score[15])) : ?>
                <td><?= $score[15] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 15) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Yatzy</td>
            <?php if (isset($score[16])) : ?>
                <td><?= $score[16] ?></td>
            <?php endif; ?>
        </tr>
        <tr
            <?php if ($turn == 16) : ?>
                class="current-turn"
            <?php endif; ?>
        >
            <td>Sum</td>
            <?php if (isset($score[17])) : ?>
                <td><?= $score[17] ?></td>
            <?php endif; ?>
        </tr>
    </tbody>
</table>
</form>
@endsection
