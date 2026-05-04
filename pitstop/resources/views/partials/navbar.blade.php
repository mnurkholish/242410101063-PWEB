@php
    $buttonClass =
        'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    $linkClass = 'transition hover:text-blue-600';
    $activeClass = 'text-blue-600';
@endphp

<header
    class="sticky top-0 z-20 flex flex-wrap items-center justify-between gap-4 border-b border-slate-200/90 bg-white/95 px-[5%] py-3.5 backdrop-blur">
    <a class="inline-flex items-center gap-3 font-black tracking-[0.08em]" href="{{ url('/') }}">
        <img src="{{ asset('img/pitstop-logo.png') }}" alt="Logo PitStop" class="h-10 w-10">
        <span>PITSTOP</span>
    </a>

    <input type="checkbox" id="menu-toggle" class="peer sr-only">
    <label for="menu-toggle"
        class="grid h-11 w-11 cursor-pointer place-items-center rounded-lg border border-slate-200 text-2xl leading-none text-blue-950 lg:hidden"
        aria-label="Buka menu">
        &#9776;
    </label>

    <nav
        class="hidden w-full border-t border-slate-200 bg-white pt-4 shadow-[0_18px_45px_rgba(14,43,82,0.10)] peer-checked:grid peer-checked:gap-4 lg:flex lg:w-auto lg:items-center lg:gap-9 lg:border-0 lg:bg-transparent lg:pt-0 lg:shadow-none">
        <ul class="grid gap-4 text-sm font-bold text-slate-500 lg:flex lg:items-center lg:gap-8">
            <li>
                <a class="{{ request()->is('/') ? $activeClass : $linkClass }}" href="{{ url('/') }}">Beranda</a>
            </li>
            <li>
                <a class="{{ request()->is('tentang') ? $activeClass : $linkClass }}" href="{{ url('/tentang') }}">Tentang</a>
            </li>
            <li>
                <a class="{{ $linkClass }}" href="{{ url('/#booking-section') }}">Booking</a>
            </li>
            <li>
                <a class="{{ $linkClass }}" href="{{ url('/#data-section') }}">Data Booking</a>
            </li>
            <li>
                <a class="{{ request()->is('dashboard') ? $activeClass : $linkClass }}" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
        </ul>
        <a href="{{ url('/#booking-section') }}"
            class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
            Buat Jadwal
        </a>
    </nav>
</header>
