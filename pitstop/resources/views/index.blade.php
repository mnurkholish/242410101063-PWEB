@extends('layouts.app')

@section('content')

    <body class="min-h-screen overflow-x-hidden bg-[#f3f6fb] text-slate-800 antialiased">
        @php
            $services = [
                ['name' => 'Ganti Oli', 'detail' => 'Rp350.000 / 30 menit'],
                ['name' => 'Servis Berkala', 'detail' => 'Rp850.000 / 120 menit'],
                ['name' => 'Perbaikan Rem', 'detail' => 'Rp275.000 / 60 menit'],
                ['name' => 'Tune Up Mesin', 'detail' => 'Rp600.000 / 90 menit'],
                ['name' => 'Spooring Balancing', 'detail' => 'Rp450.000 / 60 menit'],
                ['name' => 'Diagnosa Mesin', 'detail' => 'Rp250.000 / 45 menit'],
            ];

            $fieldClass =
                'min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100';
            $labelClass = 'text-sm font-extrabold text-slate-800';
            $buttonClass =
                'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
        @endphp

        <header
            class="sticky top-0 z-20 flex flex-wrap items-center justify-between gap-4 border-b border-slate-200/90 bg-white/95 px-[5%] py-3.5 backdrop-blur">
            <a class="inline-flex items-center gap-3 font-black tracking-[0.08em]" href="#">
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
                    <li><a class="transition hover:text-blue-600" href="#">Beranda</a></li>
                    <li><a class="transition hover:text-blue-600" href="#booking-section">Booking</a></li>
                    <li><a class="transition hover:text-blue-600" href="#data-section">Data Booking</a></li>
                    <li><a class="transition hover:text-blue-600" href="#statistik-section">Statistik</a></li>
                </ul>
                <a href="#booking-section"
                    class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                    Buat Jadwal
                </a>
            </nav>
        </header>

        <section
            class="relative flex min-h-[78vh] items-center overflow-hidden px-[5%] py-20 text-white after:absolute after:bottom-0 after:right-[5%] after:h-3 after:w-[min(520px,70vw)] after:bg-amber-400 after:content-['']"
            style="background-image: linear-gradient(90deg, rgba(7, 25, 51, 0.88), rgba(7, 25, 51, 0.36)), url('https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=1800&q=80'); background-position: center; background-size: cover;">
            <div class="relative z-10 max-w-3xl">
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-400">Booking service bengkel tanpa antre
                    panjang</p>
                <h1 class="mt-3 max-w-4xl text-4xl font-black leading-[1.04] sm:text-5xl lg:text-7xl">
                    Atur Jadwal Servis Kendaraan Lebih Cepat dan Rapi
                </h1>
                <p class="mt-4 max-w-2xl text-base text-white/90 sm:text-lg">
                    Catat data pelanggan, kendaraan, jenis layanan, jadwal kedatangan,
                    status pengerjaan, sampai estimasi biaya dalam satu dashboard ringan.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#booking-section" class="{{ $buttonClass }} bg-amber-400 text-slate-900 hover:bg-amber-300">
                        Booking Sekarang
                    </a>
                    <a href="#data-section"
                        class="{{ $buttonClass }} border border-white/40 bg-white/15 text-white hover:bg-white/25">
                        Lihat Antrean
                    </a>
                </div>
            </div>
        </section>

        <div
            class="relative z-10 mx-auto -mt-14 grid w-[min(1400px,90%)] gap-6 lg:grid-cols-[300px_minmax(0,1fr)] lg:items-start">
            <aside id="statistik-section"
                class="grid gap-4 rounded-lg border border-slate-200/90 bg-white p-4 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:grid-cols-2 lg:sticky lg:top-22 lg:grid-cols-1">
                <div class="sm:col-span-2 lg:col-span-1">
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Ringkasan bengkel</p>
                    <h2 class="mt-1 text-xl font-black leading-tight text-slate-800">Statistik Hari Ini</h2>
                </div>

                <div class="flex items-center gap-4 rounded-lg border border-blue-100 bg-blue-50 p-4">
                    <span
                        class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-white text-xs font-black text-blue-600">#</span>
                    <div>
                        <h3 class="text-sm font-bold text-slate-500">Total Booking</h3>
                        <p id="totalBooking" class="text-2xl font-black text-slate-800">0</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 rounded-lg border border-blue-100 bg-blue-50 p-4">
                    <span
                        class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-white text-xs font-black text-blue-600">Rp</span>
                    <div>
                        <h3 class="text-sm font-bold text-slate-500">Total Estimasi</h3>
                        <p id="totalEstimasi" class="text-2xl font-black text-slate-800">Rp0</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <span
                        class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-white text-xs font-black text-blue-600">!</span>
                    <div>
                        <h3 class="text-sm font-bold text-slate-500">Menunggu</h3>
                        <p id="totalMenunggu" class="text-2xl font-black text-slate-800">0</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                    <span
                        class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-white text-xs font-black text-blue-600">OK</span>
                    <div>
                        <h3 class="text-sm font-bold text-slate-500">Selesai</h3>
                        <p id="totalSelesai" class="text-2xl font-black text-slate-800">0</p>
                    </div>
                </div>
            </aside>

            <main class="grid min-w-0 gap-6">
                <section
                    class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8"
                    id="booking-section">
                    <div class="mb-5">
                        <p id="formModeLabel" class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Form
                            booking service</p>
                        <h2 id="formTitle" class="mt-1 text-2xl font-black leading-tight text-slate-800">Tambah Booking Baru
                        </h2>
                    </div>
                    <div class="form-feedback" id="formFeedback" role="status"></div>

                    <form id="bookingForm" novalidate>
                        <input type="hidden" id="bookingId">

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="form-group grid gap-2">
                                <label class="{{ $labelClass }}" for="namaPelanggan">Nama Pelanggan</label>
                                <input class="{{ $fieldClass }}" type="text" id="namaPelanggan"
                                    placeholder="Masukkan nama pelanggan" autocomplete="off">
                                <small class="error-message" id="namaPelangganError"></small>
                            </div>

                            <div class="form-group grid gap-2">
                                <label class="{{ $labelClass }}" for="nomorPlat">Nomor Plat</label>
                                <input class="{{ $fieldClass }}" type="text" id="nomorPlat"
                                    placeholder="Contoh: B 1234 XYZ" autocomplete="off">
                                <small class="error-message" id="nomorPlatError"></small>
                            </div>

                            <div class="form-group grid gap-2">
                                <label class="{{ $labelClass }}" for="jenisKendaraan">Jenis Kendaraan</label>
                                <select class="{{ $fieldClass }}" id="jenisKendaraan">
                                    <option value="">Pilih jenis kendaraan</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Pickup">Pickup</option>
                                    <option value="SUV">SUV</option>
                                </select>
                                <small class="error-message" id="jenisKendaraanError"></small>
                            </div>

                            <div class="form-group grid gap-2">
                                <label class="{{ $labelClass }}" for="merekKendaraan">Merek / Seri Kendaraan</label>
                                <input class="{{ $fieldClass }}" type="text" id="merekKendaraan"
                                    placeholder="Contoh: Toyota Avanza 2021" autocomplete="off">
                                <small class="error-message" id="merekKendaraanError"></small>
                            </div>

                            <div class="form-group grid gap-2">
                                <label class="{{ $labelClass }}" for="tanggalService">Tanggal Service</label>
                                <input class="{{ $fieldClass }}" type="date" id="tanggalService">
                                <small class="error-message" id="tanggalServiceError"></small>
                            </div>

                            <div class="form-group grid gap-2">
                                <label class="{{ $labelClass }}" for="jamService">Jam Kedatangan</label>
                                <input class="{{ $fieldClass }}" type="time" id="jamService" min="08:00"
                                    max="17:00">
                                <small class="error-message" id="jamServiceError"></small>
                            </div>
                        </div>

                        <div class="form-group service-group mt-4 grid gap-2" id="serviceGroup">
                            <label class="{{ $labelClass }}">Jenis Service</label>
                            <div class="grid gap-3 md:grid-cols-2">
                                @foreach ($services as $service)
                                    <label
                                        class="service-option flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3.5 transition hover:border-blue-600 hover:bg-blue-50">
                                        <input class="mt-1 h-4.5 w-4.5 accent-blue-600" type="checkbox"
                                            name="jenisService" value="{{ $service['name'] }}">
                                        <span class="grid min-w-0 gap-0.5 font-extrabold">
                                            {{ $service['name'] }}
                                            <small
                                                class="text-xs font-bold text-slate-500">{{ $service['detail'] }}</small>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <small class="error-message" id="jenisServiceError"></small>
                        </div>

                        <div class="mt-5 grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-2">
                            <div class="grid gap-1">
                                <span class="text-xs font-extrabold uppercase text-slate-500">Kode otomatis</span>
                                <strong id="kodePreview" class="text-blue-950">Dibuat saat disimpan</strong>
                            </div>
                            <div class="grid gap-1">
                                <span class="text-xs font-extrabold uppercase text-slate-500">Estimasi biaya</span>
                                <strong id="estimasiPreview" class="text-blue-950">Rp0</strong>
                            </div>
                            <div class="grid gap-1">
                                <span class="text-xs font-extrabold uppercase text-slate-500">Estimasi durasi</span>
                                <strong id="durasiPreview" class="text-blue-950">0 menit</strong>
                            </div>
                            <div class="grid gap-1">
                                <span class="text-xs font-extrabold uppercase text-slate-500">Status sistem</span>
                                <strong id="statusPreview" class="text-blue-950">Menunggu</strong>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <button type="button"
                                class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950"
                                id="submitButton">
                                Simpan Booking
                            </button>
                            <button type="button"
                                class="{{ $buttonClass }} bg-slate-200 text-blue-950 hover:bg-slate-300"
                                id="resetButton">
                                Reset
                            </button>
                            <button type="button"
                                class="{{ $buttonClass }} bg-slate-200 text-blue-950 hover:bg-slate-300"
                                id="cancelEditButton">
                                Batal Edit
                            </button>
                        </div>
                    </form>
                </section>

                <section
                    class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8"
                    id="data-section">
                    <div class="grid gap-2">
                        <div class="mb-3">
                            <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Antrean dan riwayat
                            </p>
                            <h2 class="mt-1 text-2xl font-black leading-tight text-slate-800">Daftar Booking Service</h2>
                        </div>

                        <div class="mb-4 grid gap-3 md:grid-cols-[1.3fr_1fr_1fr]">
                            <div class="grid gap-1.5">
                                <label class="{{ $labelClass }}" for="searchInput">Cari</label>
                                <input class="{{ $fieldClass }}" type="search" id="searchInput"
                                    placeholder="Nama, kode, atau plat">
                            </div>
                            <div class="grid gap-1.5">
                                <label class="{{ $labelClass }}" for="filterService">Filter Service</label>
                                <select class="{{ $fieldClass }}" id="filterService">
                                    <option value="Semua">Semua Service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service['name'] }}">{{ $service['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid gap-1.5">
                                <label class="{{ $labelClass }}" for="filterStatus">Filter Status</label>
                                <select class="{{ $fieldClass }}" id="filterStatus">
                                    <option value="Semua">Semua Status</option>
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="w-full overflow-x-auto md:[-webkit-overflow-scrolling:touch]">
                        <table class="w-full min-w-275 border-collapse">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelanggan</th>
                                    <th>Kendaraan</th>
                                    <th>Service</th>
                                    <th>Jadwal</th>
                                    <th>Biaya</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bookingTableBody"></tbody>
                        </table>
                    </div>
                    <p class="empty-state" id="emptyState">Belum ada data booking.</p>
                </section>
            </main>
        </div>

        <footer class="mt-12 bg-[#071933] px-[5%] py-6 text-center text-white/75">
            <p>&copy; 2026 PitStop - Sistem Booking Service Bengkel.</p>
        </footer>
    </body>
@endsection
