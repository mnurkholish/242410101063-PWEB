<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PitStop - Booking Service Bengkel')</title>
    <link rel="icon" href="{{ asset('img/favicon-dark.ico') }}" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="{{ asset('img/favicon-light.ico') }}" media="(prefers-color-scheme: light)">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @yield('content')
</body>

</html>
