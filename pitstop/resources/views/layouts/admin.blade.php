<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'PitStop Admin'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-[280px_minmax(0,1fr)]">
            @include('partials.admin-sidebar')

            <div class="min-w-0">
                <header class="border-b border-slate-200 bg-white px-[5%] py-5">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Admin Panel</p>
                            @isset($header)
                                {{ $header }}
                            @else
                                <h1 class="text-xl font-black text-blue-950">@yield('page-title', 'PitStop')</h1>
                            @endisset
                        </div>
                        <div class="text-sm font-bold text-slate-500">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                </header>

                <main>
                    @yield('content')
                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>

        @include('partials.flash')

        @stack('scripts')
    </body>
</html>
