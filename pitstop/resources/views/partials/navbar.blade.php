@php
    $buttonClass =
        'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    $linkClass = 'transition hover:text-blue-600';
    $activeClass = 'text-blue-600';
@endphp

<header
    class="sticky top-0 z-20 flex flex-wrap items-center justify-between gap-4 border-b border-slate-200/90 bg-white/95 px-[5%] py-3.5 backdrop-blur dark:border-slate-800 dark:bg-slate-950/95 dark:text-slate-100">
    <a class="inline-flex items-center gap-3 font-black tracking-[0.08em]" href="{{ url('/') }}">
        <img src="{{ asset('img/pitstop-logo.png') }}" alt="Logo PitStop" class="h-10 w-10">
        <span>PITSTOP</span>
    </a>

    <input type="checkbox" id="menu-toggle" class="peer sr-only">
    <label for="menu-toggle"
        class="grid h-11 w-11 cursor-pointer place-items-center rounded-lg border border-slate-200 text-2xl leading-none text-blue-950 dark:border-slate-700 dark:text-slate-100 lg:hidden"
        aria-label="Buka menu">
        &#9776;
    </label>

    <nav
        class="hidden w-full border-t border-slate-200 bg-white pt-4 shadow-[0_18px_45px_rgba(14,43,82,0.10)] peer-checked:grid peer-checked:gap-4 dark:border-slate-800 dark:bg-slate-950 lg:flex lg:w-auto lg:items-center lg:gap-9 lg:border-0 lg:bg-transparent lg:pt-0 lg:shadow-none">
        <ul class="grid gap-4 text-sm font-bold text-slate-500 dark:text-slate-300 lg:flex lg:items-center lg:gap-8">
            <li>
                <a class="{{ request()->is('/') ? $activeClass : $linkClass }}" href="{{ url('/') }}">Beranda</a>
            </li>
            <li>
                <a class="{{ request()->is('tentang') ? $activeClass : $linkClass }}"
                    href="{{ url('/tentang') }}">Tentang</a>
            </li>
            <li>
                <a class="{{ request()->is('kontak') ? $activeClass : $linkClass }}"
                    href="{{ route('kontak') }}">Kontak</a>
            </li>
            <li>
                <a class="{{ request()->is('layanan*') ? $activeClass : $linkClass }}"
                    href="{{ route('layanan.index') }}">Layanan</a>
            </li>
            @auth
                @unless (Auth::user()->isAdmin())
                    <li>
                        <a class="{{ $linkClass }}" href="{{ url('/#booking-section') }}">Booking</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('bookings.*') ? $activeClass : $linkClass }}"
                            href="{{ route('bookings.index') }}">Data Booking</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard') ? $activeClass : $linkClass }}"
                            href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endunless
            @endauth
            @guest
                <li>
                    <a class="{{ request()->is('login') ? $activeClass : $linkClass }}"
                        href="{{ route('login') }}">Login</a>
                </li>
                <li>
                    <a class="{{ request()->is('register') ? $activeClass : $linkClass }}"
                        href="{{ route('register') }}">Register</a>
                </li>
            @endguest
        </ul>
        <div
            class="inline-flex h-11 overflow-hidden rounded-lg border border-slate-200 bg-white text-blue-950 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            <a class="grid min-w-11 place-items-center border-r border-slate-200 px-3 text-sm font-extrabold transition hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
                href="{{ route('preferensi') }}" aria-label="Buka preferensi">
                Pref
            </a>
            <button type="button" data-theme-toggle data-theme-cookie="pitstop_theme"
                class="grid w-11 place-items-center text-lg transition hover:bg-slate-50 dark:hover:bg-slate-800"
                aria-label="Aktifkan dark mode" aria-pressed="false">
                <span data-theme-toggle-icon aria-hidden="true">☾</span>
            </button>
        </div>
        @auth
            @unless (Auth::user()->isAdmin())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                        Logout
                    </button>
                </form>
            @endunless
        @endauth
    </nav>
</header>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cookie = window.PitStopCookies;
            const buttons = document.querySelectorAll('[data-theme-toggle]');

            if (!cookie || !buttons.length) {
                return;
            }

            const updateThemeToggleButtons = () => {
                const isDark = document.documentElement.classList.contains('dark');

                buttons.forEach((button) => {
                    button.setAttribute('aria-pressed', String(isDark));
                    button.setAttribute('aria-label', isDark ? 'Aktifkan light mode' :
                        'Aktifkan dark mode');

                    const icon = button.querySelector('[data-theme-toggle-icon]');

                    if (icon) {
                        icon.textContent = isDark ? '☀' : '☾';
                    }
                });
            };

            const shouldUseDarkTheme = (theme) => {
                return theme === 'dark' || (
                    theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                );
            };

            const applyStoredTheme = () => {
                const themeCookie = buttons[0]?.dataset.themeCookie;

                if (!themeCookie) {
                    return;
                }

                document.documentElement.classList.toggle('dark', shouldUseDarkTheme(cookie.getCookie(themeCookie)));
                updateThemeToggleButtons();
            };

            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    const themeCookie = button.dataset.themeCookie;

                    if (!themeCookie) {
                        return;
                    }

                    const shouldUseDark = !document.documentElement.classList.contains('dark');
                    document.documentElement.classList.toggle('dark', shouldUseDark);
                    cookie.setCookie(themeCookie, shouldUseDark ? 'dark' : 'light');
                    updateThemeToggleButtons();
                });
            });

            applyStoredTheme();
        });
    </script>
@endpush
