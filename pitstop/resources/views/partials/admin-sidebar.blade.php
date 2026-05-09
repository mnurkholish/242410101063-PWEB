@php
    $linkBase = 'rounded-lg px-4 py-3 transition';
    $linkIdle = 'text-white/80 hover:bg-white/10 hover:text-white';
    $linkActive = 'bg-amber-400 text-slate-950';
@endphp

<aside class="border-b border-slate-200 bg-blue-950 px-[5%] py-5 text-white lg:min-h-screen lg:border-b-0 lg:px-5">
    <a class="inline-flex items-center gap-3 font-black tracking-[0.08em]" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('img/pitstop-logo.png') }}" alt="Logo PitStop" class="h-10 w-10">
        <span>PITSTOP ADMIN</span>
    </a>

    <nav class="mt-6 grid gap-2 text-sm font-extrabold">
        <a class="{{ $linkBase }} {{ request()->routeIs('admin.dashboard') ? $linkActive : $linkIdle }}"
            href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>
        <a class="{{ $linkBase }} {{ request()->routeIs('admin.layanan.*') ? $linkActive : $linkIdle }}"
            href="{{ route('admin.layanan.index') }}">
            Kelola Layanan
        </a>
        <a class="{{ $linkBase }} {{ request()->routeIs('admin.booking.*') ? $linkActive : $linkIdle }}"
            href="{{ route('admin.booking.index') }}">
            Kelola Booking
        </a>
        <a class="{{ $linkBase }} {{ request()->routeIs('admin.users.*') ? $linkActive : $linkIdle }}"
            href="{{ route('admin.users.index') }}">
            Kelola User / Pelanggan
        </a>
    </nav>

    <form class="mt-6" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="inline-flex min-h-[42px] w-full items-center justify-center rounded-lg bg-white/10 px-4 py-3 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-white/20">
            Logout
        </button>
    </form>
</aside>
