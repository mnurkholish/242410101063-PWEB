@extends('layouts.app')

@section('title', 'Data Booking - PitStop')

@section('content')
    <section class="px-[5%] py-10">
        <div class="mx-auto grid w-[min(1180px,100%)] gap-6">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Data booking pelanggan</p>
                <h1 class="mt-1 text-3xl font-black leading-tight text-slate-800">Data Booking Saya</h1>
                <p class="mt-2 max-w-2xl text-sm font-bold text-slate-500">
                    Daftar booking untuk akun {{ auth()->user()->name }}.
                </p>
            </div>

            <section class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                <form id="bookingSearchForm" class="mb-5 grid gap-3 md:grid-cols-[minmax(0,1fr)_auto]"
                    action="{{ route('bookings.search') }}" method="POST">
                    @csrf
                    <div class="grid gap-1.5">
                        <label class="text-sm font-extrabold text-slate-800" for="bookingSearchInput">
                            Cari Booking
                        </label>
                        <input
                            class="min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            type="search" id="bookingSearchInput" name="keyword"
                            placeholder="Kode, plat, layanan, atau status" autocomplete="off">
                    </div>
                    <button
                        class="self-end inline-flex min-h-[46px] items-center justify-center rounded-lg border-0 bg-blue-600 px-4 py-3 text-center font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-blue-950"
                        type="submit">
                        Cari
                    </button>
                    <p id="bookingSearchStatus" class="hidden text-sm font-bold text-slate-500 md:col-span-2" role="status">
                        Mencari data booking...
                    </p>
                </form>

                <div class="w-full overflow-x-auto">
                    <table class="w-full min-w-225 border-collapse">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kendaraan</th>
                                <th>Service</th>
                                <th>Jadwal</th>
                                <th>Biaya</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="bookingSearchResults">
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td data-label="Kode"><strong>{{ $booking['kodeBooking'] }}</strong></td>
                                    <td data-label="Kendaraan">
                                        {{ $booking['jenisKendaraan'] }}
                                        <div class="muted">{{ $booking['nomorPlat'] }} - {{ $booking['merekKendaraan'] }}</div>
                                    </td>
                                    <td data-label="Service">
                                        {{ implode(', ', $booking['jenisService']) }}
                                        <div class="muted">{{ $booking['estimasiDurasi'] }} menit</div>
                                    </td>
                                    <td data-label="Jadwal">{{ $booking['tanggalService'] }} {{ $booking['jamService'] }} WIB</td>
                                    <td data-label="Biaya">Rp{{ number_format($booking['estimasiBiaya'], 0, ',', '.') }}</td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ strtolower($booking['statusBooking']) }}">
                                            {{ $booking['statusBooking'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-slate-500">Belum ada data booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const bookingSearchForm = document.querySelector('#bookingSearchForm');
        const bookingSearchInput = document.querySelector('#bookingSearchInput');
        const bookingSearchResults = document.querySelector('#bookingSearchResults');
        const bookingSearchStatus = document.querySelector('#bookingSearchStatus');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[character]));

        const renderBookings = (bookings) => {
            if (!bookings.length) {
                bookingSearchResults.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-slate-500">Data booking tidak ditemukan.</td>
                    </tr>
                `;
                return;
            }

            bookingSearchResults.innerHTML = bookings.map((booking) => `
                <tr>
                    <td data-label="Kode"><strong>${escapeHtml(booking.kodeBooking)}</strong></td>
                    <td data-label="Kendaraan">
                        ${escapeHtml(booking.jenisKendaraan)}
                        <div class="muted">${escapeHtml(booking.nomorPlat)} - ${escapeHtml(booking.merekKendaraan)}</div>
                    </td>
                    <td data-label="Service">
                        ${booking.jenisService.map(escapeHtml).join(', ')}
                        <div class="muted">${escapeHtml(booking.estimasiDurasi)} menit</div>
                    </td>
                    <td data-label="Jadwal">${escapeHtml(booking.tanggalService)} ${escapeHtml(booking.jamService)} WIB</td>
                    <td data-label="Biaya">Rp${Number(booking.estimasiBiaya).toLocaleString('id-ID')}</td>
                    <td data-label="Status">
                        <span class="status-badge status-${escapeHtml(booking.statusBooking).toLowerCase()}">
                            ${escapeHtml(booking.statusBooking)}
                        </span>
                    </td>
                </tr>
            `).join('');
        };

        const searchBookings = async () => {
            bookingSearchStatus.classList.remove('hidden');

            try {
                const response = await fetch(bookingSearchForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        keyword: bookingSearchInput.value,
                    }),
                });

                if (!response.ok) {
                    throw new Error('Pencarian gagal.');
                }

                const data = await response.json();
                renderBookings(data.bookings);
            } catch (error) {
                bookingSearchResults.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-red-600">Pencarian gagal. Coba ulangi lagi.</td>
                    </tr>
                `;
            } finally {
                bookingSearchStatus.classList.add('hidden');
            }
        };

        bookingSearchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            searchBookings();
        });

        bookingSearchInput.addEventListener('input', () => {
            clearTimeout(bookingSearchInput.searchTimeout);
            bookingSearchInput.searchTimeout = setTimeout(searchBookings, 300);
        });
    </script>
@endpush
