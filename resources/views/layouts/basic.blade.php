<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Yatzy</title>
        <link rel="stylesheet" type="text/css" href={{ URL::asset('css/style.css'); }} >

    </head>
    <body>
        @include("nav")
        <main>
            @yield("content")
        </main>
        @include("footer")
    </body>
</html>
