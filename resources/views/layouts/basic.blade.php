<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Yatzy</title>
        <link rel="stylesheet" type="text/css" href={{ URL::asset('css/style.css'); }} >
        <script src="https://kit.fontawesome.com/7d2dca549c.js" crossorigin="anonymous"></script>

    </head>
    <body>
        @include("nav")
        <main>
            @yield("content")
        </main>
        @include("footer")
    </body>
</html>
