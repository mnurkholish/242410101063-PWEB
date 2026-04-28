<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - PitStop</title>
    <link rel="icon" href="{{ asset('img/favicon-dark.ico') }}" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="{{ asset('img/favicon-light.ico') }}" media="(prefers-color-scheme: light)">
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f3f6fb] text-slate-800 antialiased">
    @php
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';

        $values = [
            [
                'number' => '01',
                'title' => 'Pelayanan Tepat Waktu',
                'description' =>
                    'PitStop mengutamakan proses service yang terjadwal, jelas, dan tidak membuat pelanggan menunggu tanpa kepastian.',
            ],
            [
                'number' => '02',
                'title' => 'Teknisi Terpercaya',
                'description' =>
                    'Setiap kendaraan ditangani dengan teliti oleh tim yang memahami kebutuhan perawatan harian maupun perbaikan teknis.',
            ],
            [
                'number' => '03',
                'title' => 'Transparansi Layanan',
                'description' =>
                    'Pelanggan mendapatkan informasi layanan, estimasi biaya, dan progres pekerjaan secara terbuka sejak awal.',
            ],
        ];

        $services = [
            'Ganti oli dan pemeriksaan ringan kendaraan.',
            'Servis berkala untuk mobil, motor, SUV, dan pickup.',
            'Perbaikan rem, tune up mesin, serta diagnosa kerusakan.',
            'Spooring balancing untuk menjaga kenyamanan berkendara.',
        ];
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
                <li><a class="transition hover:text-blue-600" href="{{ url('/') }}">Beranda</a></li>
                <li><a class="text-blue-600" href="{{ url('/tentang') }}">Tentang</a></li>
                <li><a class="transition hover:text-blue-600" href="{{ url('/#booking-section') }}">Booking</a></li>
                <li><a class="transition hover:text-blue-600" href="#layanan">Layanan</a></li>
                <li><a class="transition hover:text-blue-600" href="{{ url('/dashboard') }}">Dashboard</a></li>
            </ul>
            <a href="{{ url('/#booking-section') }}"
                class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                Buat Jadwal
            </a>
        </nav>
    </header>

    <main>
        <section
            class="relative isolate overflow-hidden bg-[#071933] px-[5%] py-20 text-white after:absolute after:bottom-0 after:right-[5%] after:h-3 after:w-[min(520px,70vw)] after:bg-amber-400 after:content-['']">
            <div
                class="absolute inset-0 -z-10 bg-[linear-gradient(90deg,rgba(7,25,51,0.94),rgba(7,25,51,0.58)),url('https://images.unsplash.com/photo-1487754180451-c456f719a1fc?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center">
            </div>
            <div class="grid min-h-[58vh] items-center gap-10 lg:grid-cols-[minmax(0,1.05fr)_minmax(320px,0.95fr)]">
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-400">Company profile</p>
                    <h1 class="mt-3 max-w-4xl text-4xl font-black leading-[1.04] sm:text-5xl lg:text-7xl">
                        PitStop, Partner Perawatan Kendaraan yang Siap Diandalkan
                    </h1>
                    <p class="mt-4 max-w-2xl text-base text-white/90 sm:text-lg">
                        PitStop adalah perusahaan layanan bengkel otomotif yang berfokus pada perawatan,
                        pemeriksaan, dan perbaikan kendaraan dengan proses yang rapi, cepat, dan transparan.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ url('/#booking-section') }}"
                            class="{{ $buttonClass }} bg-amber-400 text-slate-900 hover:bg-amber-300">
                            Booking Service
                        </a>
                        <a href="#layanan"
                            class="{{ $buttonClass }} border border-white/40 bg-white/15 text-white hover:bg-white/25">
                            Lihat Layanan
                        </a>
                    </div>
                </div>

                <div
                    class="rounded-lg border border-white/15 bg-white/10 p-5 shadow-[0_18px_45px_rgba(0,0,0,0.24)] backdrop-blur">
                    <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                        <div class="rounded-lg border border-white/10 bg-white/95 p-4 text-slate-800">
                            <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-500">Nama</p>
                            <strong class="mt-1 block text-2xl font-black text-blue-950">PitStop</strong>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/95 p-4 text-slate-800">
                            <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-500">Jam Operasional</p>
                            <strong class="mt-1 block text-2xl font-black text-blue-950">08.00 - 17.00</strong>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/95 p-4 text-slate-800">
                            <p class="text-xs font-black uppercase tracking-[0.1em] text-slate-500">Layanan Utama</p>
                            <strong class="mt-1 block text-2xl font-black text-blue-950">Service Kendaraan</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto grid w-[min(1180px,90%)] gap-6 py-14 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div class="lg:sticky lg:top-[96px]">
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Tentang perusahaan</p>
                <h2 class="mt-2 text-3xl font-black leading-tight text-slate-800 sm:text-4xl">
                    Kami menjaga kendaraan pelanggan tetap siap jalan.
                </h2>
                <p class="mt-4 text-base leading-7 text-slate-600">
                    PitStop hadir untuk membantu pelanggan merawat kendaraan dengan lebih tenang.
                    Kami percaya bengkel yang baik bukan hanya memperbaiki kerusakan, tetapi juga memberi
                    penjelasan yang jelas, jadwal yang tertata, dan hasil kerja yang dapat dipercaya.
                </p>
            </div>

            <div class="grid gap-4">
                @foreach ($values as $value)
                    <article
                        class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)]">
                        <div class="flex items-start gap-4">
                            <span
                                class="grid h-12 w-12 shrink-0 place-items-center rounded-lg bg-blue-50 text-sm font-black text-blue-600">
                                {{ $value['number'] }}
                            </span>
                            <div>
                                <h3 class="text-xl font-black text-slate-800">{{ $value['title'] }}</h3>
                                <p class="mt-2 leading-7 text-slate-600">{{ $value['description'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="bg-white px-[5%] py-14" id="layanan">
            <div class="mx-auto grid w-full max-w-[1180px] gap-8 lg:grid-cols-[1fr_1fr] lg:items-center">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Layanan PitStop</p>
                    <h2 class="mt-2 text-3xl font-black leading-tight text-slate-800 sm:text-4xl">
                        Layanan bengkel untuk kebutuhan kendaraan harian.
                    </h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">
                        Dari perawatan rutin sampai pemeriksaan teknis, PitStop membantu pelanggan
                        menjaga performa kendaraan agar tetap nyaman, aman, dan efisien digunakan.
                    </p>
                </div>

                <ol class="grid gap-3">
                    @foreach ($services as $service)
                        <li class="flex gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <span
                                class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-amber-400 text-sm font-black text-slate-900">
                                {{ $loop->iteration }}
                            </span>
                            <p class="font-bold leading-7 text-slate-700">{{ $service }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        <section class="mx-auto w-[min(1180px,90%)] py-14">
            <div
                class="grid gap-6 rounded-lg border border-slate-200/90 bg-[#071933] p-6 text-white shadow-[0_18px_45px_rgba(14,43,82,0.18)] lg:grid-cols-[1fr_auto] lg:items-center lg:p-8">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-400">Kunjungi PitStop</p>
                    <h2 class="mt-2 text-3xl font-black leading-tight">Rawat kendaraan sebelum masalah jadi lebih besar.
                    </h2>
                    <p class="mt-3 max-w-2xl text-white/80">
                        Jadwalkan service kendaraan Anda dan biarkan tim PitStop membantu pemeriksaan serta
                        perawatannya.
                    </p>
                </div>
                <a href="{{ url('/#booking-section') }}"
                    class="{{ $buttonClass }} bg-amber-400 text-slate-900 hover:bg-amber-300">
                    Booking Service
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-[#071933] px-[5%] py-6 text-center text-white/75">
        <p>&copy; 2026 PitStop - Sistem Booking Service Bengkel.</p>
    </footer>
</body>

</html>
