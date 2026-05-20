<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'PitStop'))</title>

        <script>
            (() => {
                const getCookieValue = (name) => {
                    const target = `${encodeURIComponent(name)}=`;
                    const value = document.cookie
                        .split('; ')
                        .find((item) => item.startsWith(target))
                        ?.slice(target.length);

                    return decodeURIComponent(value || '');
                };

                const theme = getCookieValue('pitstop_theme') || 'light';
                const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const shouldUseDark = theme === 'dark' || (theme === 'system' && systemDark);

                const fontSizes = {
                    small: '15px',
                    normal: '16px',
                    large: '18px',
                };
                const fontSize = getCookieValue('pitstop_font_size') || 'normal';

                document.documentElement.classList.toggle('dark', shouldUseDark);
                document.documentElement.style.fontSize = fontSizes[fontSize] || fontSizes.normal;
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
        @include('partials.navbar')

        @isset($header)
            <header class="border-b border-slate-200 bg-white px-[5%] py-5">
                {{ $header }}
            </header>
        @endisset

        <main>
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        @include('partials.flash')

        @stack('scripts')
    </body>
</html>
