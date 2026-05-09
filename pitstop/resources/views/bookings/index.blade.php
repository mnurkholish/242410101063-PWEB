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
                        <tbody>
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
