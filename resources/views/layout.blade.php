<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Style / CSS -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Laravel -->
        <link href="{{ asset(elixir('css/app.css')) }}" rel="stylesheet" type="text/css">
        @yield('style')

        <!-- Scripts / JS -->
        <script src="{{ asset(elixir('js/app.js')) }}" type="text/javascript"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
        @yield('scripts')

    </head>
    <body>
        @yield('body')

        <footer>
            Generated in {{ number_format(1000 * (microtime(true) - LARAVEL_START), 0) }} ms
        </footer>
    </body>
</html>
