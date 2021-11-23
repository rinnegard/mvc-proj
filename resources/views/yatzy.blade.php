@extends("layouts.basic")

@section("content")
<?php

$header = $header ?? null;
$message = $message ?? null;


$die1 = Session::get('yatzy')->show();
$savedDie = Session::get('yatzy')->showSaved();
$turn = Session::get('yatzy')->getTurn();
$throws = Session::get('yatzy')->getThrows();
$score = Session::get('yatzy')->getScore();

?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<?php if (!isset($gameover)) : ?>
    <p>Select the dice you want to save.</p>
    <p>
        <form  action="" method="post">
            @csrf
            <?php foreach ($die1 as $key => $value) : ?>
                <input type="checkbox" name="<?= $key ?>" value="<?= $value->getFace() ?>"><?= $value->getFace(); ?></input>
            <?php endforeach; ?>
            <input type="submit" name="save" value="Save">
        </form>
    </p>

    <p>You are currently looking for dice that show <?= $turn + 1 ?></p>
    <p>You have <?= 3 - $throws ?> throws remaining</p>

    <?php if (!isset($roundEnd)) : ?>
    <form  action="" method="post">
        @csrf
        <input type="submit" name="roll" value="Roll!">
    </form>
    <?php endif; ?>
    <?php if (isset($roundEnd)) : ?>
        <form  action="" method="post">
            @csrf
            <input type="submit" name="next" value="next">
        </form>
        <p><?= $roundEnd ?></p>
    <?php endif; ?>
<?php endif; ?>
<table>
    <caption>Scoreboard</caption>
    <tr>
        <th>Player</th>
        <td>You</td>
    </tr>
    <tr>
        <td>Ones</td>
        <?php if (isset($score[0])) : ?>
            <td><?= $score[0] ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Twoes</td>
        <?php if (isset($score[1])) : ?>
            <td><?= $score[1] ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Threes</td>
        <?php if (isset($score[2])) : ?>
            <td><?= $score[2] ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Fours</td>
        <?php if (isset($score[3])) : ?>
            <td><?= $score[3] ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Fives</td>
        <?php if (isset($score[4])) : ?>
            <td><?= $score[4] ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Sixes</td>
        <?php if (isset($score[5])) : ?>
            <td><?= $score[5] ?></td>
        <?php endif; ?>
    </tr>
    <tr>
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
</table>

<?php if (isset($gameover)) : ?>
    <p><?= $gameover ?></p>
<?php endif; ?>


@endsection
