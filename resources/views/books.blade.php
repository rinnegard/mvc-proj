@extends("layouts.basic")

@section("content")
    @foreach ($books as $key => $value)
        <div class="book">
            <p>
                Title: {{ $books[$key]["title"] }}
            </p>
            <p>
                Author: {{ $books[$key]["author"] }}
            </p>
            <p>
                isbn: {{ $books[$key]["isbn"] }}
            </p>
            <img src=" {{ $books[$key]["url"] }}">
            </img>
        </div>
    @endforeach

@endsection
