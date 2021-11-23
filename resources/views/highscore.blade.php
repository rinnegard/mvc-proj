@extends("layouts.basic")

@section("content")

        <table>
            <tr>
                <th>Player</td>
                <th>Score</td>
            </tr>
            @foreach ($highscore as $key => $value)
                <tr>
                    <td>{{ $value["id"] }}</td>
                    <td>{{ $value["score"] }}</td>
                </tr>
            @endforeach
        </table>

@endsection
