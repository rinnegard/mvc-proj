@extends("layouts.basic")

@section("content")

        <table>
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
