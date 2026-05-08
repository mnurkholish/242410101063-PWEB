<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PitStop - Booking Service Bengkel')</title>
    <link rel="icon" href="{{ asset('img/favicon-dark.ico') }}" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="{{ asset('img/favicon-light.ico') }}" media="(prefers-color-scheme: light)">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f3f6fb] text-slate-800 antialiased">
    @include('partials.navbar')

    <main>
        @if (session('success'))
            <div class="flash-toast" role="status" aria-live="polite">
                <span class="flash-toast-icon">OK</span>
                <div>
                    <p class="flash-toast-title">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="flash-toast flash-toast-error" role="alert" aria-live="assertive">
                <span class="flash-toast-icon flash-toast-icon-error">!</span>
                <div>
                    <p class="flash-toast-title flash-toast-title-error">Gagal</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif


        @yield('content')
    </main>

    <footer class="mt-12 bg-[#071933] px-[5%] py-6 text-center text-white/75">
        <p>&copy; 2026 PitStop - Sistem Booking Service Bengkel.</p>
    </footer>

    @stack('scripts')
</body>

</html>
