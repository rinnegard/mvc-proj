@extends("layouts.basic")

@section("content")
    <div class="content">
        <p>Welcome to Yatzy! I hope you know the rules!</p>

        <form  action="" method="post">
            @csrf
            <label for="name">What's your name?</label>
            <input type="text" name="name" value="">
            <input class="button" type="submit" name="submit" value="Start the game">
        </form>
    </div>

@endsection
