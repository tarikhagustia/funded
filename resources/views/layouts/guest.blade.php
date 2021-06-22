<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <link href="{{ mix('css/style.css') }}" rel="stylesheet">
    </head>
    <body class="c-app flex-row align-items-center">
    <div class="container">
        @yield('content')
    </div>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @stack('javascript')
    </body>
</html>
