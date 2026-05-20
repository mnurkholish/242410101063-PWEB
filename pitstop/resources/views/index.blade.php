@extends('layouts.app')

@section('content')
    @php
        $fieldClass =
            'min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:bg-slate-950 dark:focus:ring-blue-500/20';
        $labelClass = 'text-sm font-extrabold text-slate-800 dark:text-slate-100';
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    @endphp

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
            class="grid gap-4 rounded-lg border border-slate-200/90 bg-white p-4 shadow-[0_18px_45px_rgba(14,43,82,0.10)] dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:grid-cols-2 lg:sticky lg:top-22 lg:grid-cols-1">
            <div class="sm:col-span-2 lg:col-span-1">
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Ringkasan bengkel</p>
                <h2 class="mt-1 text-xl font-black leading-tight text-slate-800 dark:text-slate-100">Statistik Hari Ini</h2>
            </div>

            <x-stat-card judul="Total Booking" nilai="0" ikon="#" warna="blue" id="totalBooking" />
            <x-stat-card judul="Total Estimasi" nilai="Rp0" ikon="Rp" warna="blue" id="totalEstimasi" />
            <x-stat-card judul="Menunggu" nilai="0" ikon="!" warna="amber" id="totalMenunggu" />
            <x-stat-card judul="Selesai" nilai="0" ikon="OK" warna="emerald" id="totalSelesai" />

            <section class="rounded-lg border border-blue-100 bg-blue-50/70 p-4 dark:border-slate-700 dark:bg-slate-950" data-weather-widget
                data-weather-api="https://wttr.in/Jember?format=j1" aria-live="polite">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.12em] text-blue-700 dark:text-blue-300">Cuaca area bengkel</p>
                        <h3 class="mt-1 text-lg font-black leading-tight text-blue-950 dark:text-slate-100" data-weather-location>
                            Jember
                        </h3>
                    </div>
                    <span
                        class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-white text-xs font-black text-blue-700 shadow-sm dark:bg-slate-800 dark:text-blue-300"
                        data-weather-icon>
                        --
                    </span>
                </div>

                <div class="mt-4 grid gap-2">
                    <div class="flex items-end gap-2">
                        <strong class="text-3xl font-black leading-none text-slate-800 dark:text-slate-100" data-weather-temp>
                            --
                        </strong>
                        <span class="pb-1 text-sm font-extrabold text-slate-500 dark:text-slate-400">Celsius</span>
                    </div>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-300" data-weather-description>
                        Mengambil data cuaca terkini...
                    </p>
                </div>

                <div class="mt-4 hidden items-center gap-2 text-sm font-extrabold text-blue-700 dark:text-blue-300" data-weather-loading>
                    <span class="h-4 w-4 animate-spin rounded-full border-2 border-blue-200 border-t-blue-700"></span>
                    Memuat cuaca
                </div>

                <p class="mt-4 hidden rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-bold text-red-600 dark:border-red-500/40 dark:bg-red-950/30 dark:text-red-300"
                    data-weather-error>
                    Data cuaca belum bisa dimuat.
                </p>
            </section>

            <section class="grid gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-950">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Session landing page</p>
                    <h2 class="mt-1 text-lg font-black leading-tight text-slate-800 dark:text-slate-100">
                        Riwayat Kunjungan
                    </h2>
                </div>

                <div class="grid gap-3">
                    <div class="rounded-lg bg-white p-3 dark:bg-slate-900">
                        <p class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Jumlah</p>
                        <strong class="text-2xl font-black text-blue-950 dark:text-blue-200">{{ $visitCount }}</strong>
                    </div>
                    <div class="rounded-lg bg-white p-3 dark:bg-slate-900">
                        <p class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Pertama</p>
                        <strong class="text-sm font-black text-slate-800 dark:text-slate-100">{{ $firstVisitAt }}</strong>
                    </div>
                    <div class="rounded-lg bg-white p-3 dark:bg-slate-900">
                        <p class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Terakhir</p>
                        <strong class="text-sm font-black text-slate-800 dark:text-slate-100">{{ $lastVisitAt }}</strong>
                    </div>
                </div>

                <form method="POST" action="{{ route('home.reset-visits') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex min-h-[42px] w-full items-center justify-center rounded-lg bg-red-50 px-4 py-3 text-center font-extrabold text-red-600 transition hover:-translate-y-0.5 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-300 dark:hover:bg-red-500/20">
                        Reset Hitungan
                    </button>
                </form>
            </section>
        </aside>

        <div class="grid min-w-0 gap-6">
            <section
                class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:p-8"
                id="booking-section">
                <div class="mb-5">
                    <p id="formModeLabel" class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Form
                        booking service</p>
                    <h2 id="formTitle" class="mt-1 text-2xl font-black leading-tight text-slate-800 dark:text-slate-100">Tambah Booking Baru
                    </h2>
                </div>
                <div class="form-feedback" id="formFeedback" role="status"></div>

                <form id="bookingForm" action="{{ route('dashboard.bookings.store') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" id="bookingId" name="bookingId">
                    <input type="hidden" id="kodeBookingInput" name="kodeBooking">

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="form-group grid gap-2">
                            <label class="{{ $labelClass }}" for="namaPelanggan">Nama Pelanggan</label>
                            <input class="{{ $fieldClass }}" type="text" id="namaPelanggan" name="namaPelanggan"
                                value="{{ auth()->user()->name ?? '' }}" placeholder="Login untuk memakai nama akun"
                                autocomplete="off" @auth readonly @endauth>
                            <small class="error-message" id="namaPelangganError"></small>
                        </div>

                        <div class="form-group grid gap-2">
                            <label class="{{ $labelClass }}" for="nomorPlat">Nomor Plat</label>
                            <input class="{{ $fieldClass }}" type="text" id="nomorPlat" name="nomorPlat"
                                placeholder="Contoh: B 1234 XYZ" autocomplete="off">
                            <small class="error-message" id="nomorPlatError"></small>
                        </div>

                        <div class="form-group grid gap-2">
                            <label class="{{ $labelClass }}" for="jenisKendaraan">Jenis Kendaraan</label>
                            <select class="{{ $fieldClass }}" id="jenisKendaraan" name="jenisKendaraan">
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
                            <input class="{{ $fieldClass }}" type="text" id="merekKendaraan" name="merekKendaraan"
                                placeholder="Contoh: Toyota Avanza 2021" autocomplete="off">
                            <small class="error-message" id="merekKendaraanError"></small>
                        </div>

                        <div class="form-group grid gap-2">
                            <label class="{{ $labelClass }}" for="tanggalService">Tanggal Service</label>
                            <input class="{{ $fieldClass }}" type="date" id="tanggalService"
                                name="tanggalService">
                            <small class="error-message" id="tanggalServiceError"></small>
                        </div>

                        <div class="form-group grid gap-2">
                            <label class="{{ $labelClass }}" for="jamService">Jam Kedatangan</label>
                            <input class="{{ $fieldClass }}" type="time" id="jamService" name="jamService"
                                min="08:00" max="17:00">
                            <small class="error-message" id="jamServiceError"></small>
                        </div>

                        <div class="form-group grid gap-2 md:col-span-2">
                            <label class="{{ $labelClass }}" for="slot">Slot Bengkel</label>
                            <select class="{{ $fieldClass }}" id="slot" name="slot">
                                <option value="">Pilih slot</option>
                                <option value="A">Slot A</option>
                                <option value="B">Slot B</option>
                                <option value="C">Slot C</option>
                            </select>
                            <small class="error-message" id="slotError"></small>
                            @error('slot')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group service-group mt-4 grid gap-2" id="serviceGroup">
                        <label class="{{ $labelClass }}">Jenis Service</label>
                        <div class="grid gap-3 md:grid-cols-2">
                            @forelse ($layanans as $layanan)
                                <label
                                    class="service-option flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3.5 transition hover:border-blue-600 hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-950 dark:hover:border-blue-400 dark:hover:bg-slate-800">
                                    <input class="mt-1 h-4.5 w-4.5 accent-blue-600" type="checkbox" name="layanan_id[]"
                                        value="{{ $layanan->id }}">
                                    <span class="grid min-w-0 gap-0.5 font-extrabold">
                                        {{ $layanan->nama }}
                                        <small
                                            class="text-xs font-bold text-slate-500 dark:text-slate-400">Rp{{ number_format($layanan->estimasi_harga, 0, ',', '.') }}
                                            / {{ $layanan->estimasi_durasi }} menit</small>
                                    </span>
                                </label>
                            @empty
                                <p
                                    class="rounded-lg border border-dashed border-slate-200 bg-slate-50 p-4 text-sm font-bold text-slate-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-400">
                                    Belum ada layanan aktif.
                                </p>
                            @endforelse
                        </div>
                        <small class="error-message" id="jenisServiceError"></small>
                        @error('layanan_id')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-5 grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-950 md:grid-cols-2">
                        <div class="grid gap-1">
                            <span class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Kode otomatis</span>
                            <strong id="kodePreview" class="text-blue-950 dark:text-blue-200">Dibuat saat disimpan</strong>
                        </div>
                        <div class="grid gap-1">
                            <span class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Estimasi biaya</span>
                            <strong id="estimasiPreview" class="text-blue-950 dark:text-blue-200">Rp0</strong>
                        </div>
                        <div class="grid gap-1">
                            <span class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Estimasi durasi</span>
                            <strong id="durasiPreview" class="text-blue-950 dark:text-blue-200">0 menit</strong>
                        </div>
                        <div class="grid gap-1">
                            <span class="text-xs font-extrabold uppercase text-slate-500 dark:text-slate-400">Status sistem</span>
                            <strong id="statusPreview" class="text-blue-950 dark:text-blue-200">Menunggu</strong>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button type="submit"
                            class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950"
                            id="submitButton">
                            Simpan Booking
                        </button>
                        <button type="button" class="{{ $buttonClass }} bg-slate-200 text-blue-950 hover:bg-slate-300 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700"
                            id="resetButton">
                            Reset
                        </button>
                        <button type="button" class="{{ $buttonClass }} bg-slate-200 text-blue-950 hover:bg-slate-300 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700"
                            id="cancelEditButton">
                            Batal Edit
                        </button>
                    </div>
                </form>
            </section>

            <section
                class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:p-8"
                id="data-section">
                <div class="grid gap-2">
                    <div class="mb-3">
                        <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Antrean dan riwayat
                        </p>
                        <h2 class="mt-1 text-2xl font-black leading-tight text-slate-800 dark:text-slate-100">Daftar Booking Service</h2>
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
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
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
        </div>
    </div>
@endsection

@push('scripts')
    @php
        $pitStopServices = $layanans->mapWithKeys(
            fn($layanan) => [
                (string) $layanan->id => [
                    'name' => $layanan->nama,
                    'price' => $layanan->estimasi_harga,
                    'duration' => $layanan->estimasi_durasi,
                ],
            ],
        );
    @endphp

    <script>
        window.PitStopServices = @json($pitStopServices);
        window.PitStopInitialBookings = @json($bookings);
        window.PitStopPage = {
            name: 'beranda',
        };

        const loadWeather = async () => {
            const widget = document.querySelector('[data-weather-widget]');

            if (!widget) {
                return;
            }

            const loading = widget.querySelector('[data-weather-loading]');
            const error = widget.querySelector('[data-weather-error]');
            const location = widget.querySelector('[data-weather-location]');
            const temperature = widget.querySelector('[data-weather-temp]');
            const description = widget.querySelector('[data-weather-description]');
            const icon = widget.querySelector('[data-weather-icon]');

            loading.classList.remove('hidden');
            loading.classList.add('flex');
            error.classList.add('hidden');

            try {
                const response = await fetch(widget.dataset.weatherApi);

                if (!response.ok) {
                    throw new Error('API cuaca gagal dimuat.');
                }

                const data = await response.json();
                const current = data.current_condition?.[0] ?? {};
                const area = data.nearest_area?.[0] ?? {};
                const city = area.areaName?.[0]?.value ?? 'Jember';
                const region = area.region?.[0]?.value ?? '';

                location.textContent = region ? `${city}, ${region}` : city;
                temperature.textContent = current.temp_C ? `${current.temp_C}°` : '--';
                description.textContent = current.weatherDesc?.[0]?.value ?? 'Data cuaca tersedia';
                icon.textContent = 'WX';
            } catch (weatherError) {
                error.textContent = 'Data cuaca belum bisa dimuat. Coba muat ulang halaman.';
                error.classList.remove('hidden');
            } finally {
                loading.classList.add('hidden');
                loading.classList.remove('flex');
            }
        };

        loadWeather();
    </script>
@endpush
