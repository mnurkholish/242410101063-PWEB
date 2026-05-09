<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'PitStop'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
        @php
            $isAdminArea = request()->routeIs('admin.*');
        @endphp

        @if ($isAdminArea)
            <div class="min-h-screen lg:grid lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="border-b border-slate-200 bg-blue-950 px-[5%] py-5 text-white lg:min-h-screen lg:border-b-0 lg:px-5">
                    <a class="inline-flex items-center gap-3 font-black tracking-[0.08em]" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('img/pitstop-logo.png') }}" alt="Logo PitStop" class="h-10 w-10">
                        <span>PITSTOP ADMIN</span>
                    </a>

                    <nav class="mt-6 grid gap-2 text-sm font-extrabold">
                        <a class="rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-slate-950' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                            href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                        <a class="rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.layanan.*') ? 'bg-amber-400 text-slate-950' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                            href="{{ route('admin.layanan.index') }}">
                            Management Layanan
                        </a>
                        <a class="rounded-lg px-4 py-3 text-white/80 transition hover:bg-white/10 hover:text-white"
                            href="{{ route('home') }}">
                            Lihat Website
                        </a>
                    </nav>
                </aside>

                <div class="min-w-0">
                    @include('layouts.navigation')

                    @isset($header)
                        <header class="border-b border-slate-200 bg-white px-[5%] py-5">
                            {{ $header }}
                        </header>
                    @endisset

                    <main>
                        @yield('content')
                        {{ $slot ?? '' }}
                    </main>
                </div>
            </div>
        @else
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
        @endif

        @if (session('success') || session('status'))
            <div class="flash-toast" role="status">
                <span class="flash-toast-icon">OK</span>
                <div>
                    <p class="flash-toast-title">Berhasil</p>
                    <p>{{ session('success') ?? session('status') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="flash-toast flash-toast-error" role="alert">
                <span class="flash-toast-icon flash-toast-icon-error">!</span>
                <div>
                    <p class="flash-toast-title flash-toast-title-error">Gagal</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @stack('scripts')
    </body>
</html>
