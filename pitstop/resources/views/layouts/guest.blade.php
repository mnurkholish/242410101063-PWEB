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
        <main class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_520px]">
            <section class="relative hidden overflow-hidden bg-blue-950 px-[6%] py-12 text-white lg:grid lg:content-between">
                <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(7,25,51,0.94),rgba(7,25,51,0.54)),url('https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center"></div>
                <a class="relative z-10 inline-flex items-center gap-3 font-black tracking-[0.08em]" href="{{ route('home') }}">
                    <img src="{{ asset('img/pitstop-logo.png') }}" alt="Logo PitStop" class="h-10 w-10">
                    <span>PITSTOP</span>
                </a>
                <div class="relative z-10 max-w-2xl">
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-400">Booking service bengkel</p>
                    <h1 class="mt-3 text-5xl font-black leading-tight">Kelola Jadwal Servis Lebih Rapi</h1>
                    <p class="mt-4 text-lg text-white/85">Masuk untuk mengatur dashboard pelanggan dan pantau layanan PitStop.</p>
                </div>
            </section>

            <section class="flex min-h-screen items-center justify-center px-[5%] py-10">
                <div class="w-full max-w-md">
                    <a class="mb-8 inline-flex items-center gap-3 font-black tracking-[0.08em] text-blue-950 lg:hidden" href="{{ route('home') }}">
                        <img src="{{ asset('img/pitstop-logo.png') }}" alt="Logo PitStop" class="h-10 w-10">
                        <span>PITSTOP</span>
                    </a>

                    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
