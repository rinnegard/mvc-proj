@extends("layouts.basic")

@section("content")
        <form  action="" method="post">
            @csrf
            <input type="text" name="search" value="" placeholder="Search">
            <input class="button" type="submit" name="submit" value="Search">
        </form>
        <table>
            @isset($posted)
                <caption>Displaying results for "{{ $posted }}":</caption>
            @endisset
            <tr>
                <th>Player</td>
                <th>Score</td>
                <th>Histogram</th>
            </tr>
            @foreach ($highscore as $key => $value)
                <tr>
                    <td>{{ $value["name"] }}</td>
                    <td>{{ $value["score"] }}</td>
                    <td>
                        <table>
                            <tr>
                                <th>Dice</th>
                                @foreach (json_decode($value["histogram"]) as $key1 => $value1)
                                <td>{{ $key1 + 1 }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <th>Count</th>
                                @foreach (json_decode($value["histogram"]) as $key1 => $value1)
                                <td>{{ $value1 }}</td>
                                @endforeach
                            </tr>

                        </table>
                    </td>
                </tr>
            @endforeach
        </table>

@endsection
