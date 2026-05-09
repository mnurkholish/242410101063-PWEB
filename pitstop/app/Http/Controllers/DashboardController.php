<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Layanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'bookings' => $this->userBookings(),
        ]);
    }

    public function bookings()
    {
        return view('bookings.index', [
            'bookings' => $this->userBookings(),
        ]);
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'totalLayanan' => Layanan::count(),
            'layananAktif' => Layanan::where('is_active', true)->count(),
            'bookings' => $this->dummyBookings(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaPelanggan' => ['required', 'string', 'min:3'],
            'nomorPlat' => ['required', 'string'],
            'jenisKendaraan' => ['required', 'string'],
            'merekKendaraan' => ['required', 'string'],
            'tanggalService' => ['required', 'date'],
            'jamService' => ['required'],
            'jenisService' => ['required', 'array', 'min:1'],
        ]);

        $kodeBooking = $request->input('kodeBooking', 'booking baru');

        return redirect()
            ->route('dashboard')
            ->with('success', "Booking {$kodeBooking} berhasil disimpan.");
    }

    private function userBookings(): array
    {
        return Booking::query()
            ->with(['layanans', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn (Booking $booking): array => [
                'kodeBooking' => 'PS-'.str_pad((string) $booking->id, 3, '0', STR_PAD_LEFT),
                'namaPelanggan' => $booking->user?->name ?? auth()->user()?->name,
                'nomorPlat' => $booking->nomor_plat,
                'jenisKendaraan' => $booking->jenis_kendaraan,
                'merekKendaraan' => $booking->merek_kendaraan,
                'jenisService' => $booking->layanans->pluck('nama')->all(),
                'tanggalService' => $booking->start_time?->format('Y-m-d'),
                'jamService' => $booking->start_time?->format('H:i'),
                'estimasiBiaya' => $booking->total_estimasi_harga,
                'estimasiDurasi' => $booking->total_estimasi_durasi,
                'statusBooking' => $this->statusLabel($booking->status),
            ])
            ->all();
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => 'Menunggu',
        };
    }

    private function dummyBookings(): array
    {
        return [
            [
                'kodeBooking' => 'PS-001',
                'namaPelanggan' => 'Budi Santoso',
                'nomorPlat' => 'B 1234 XYZ',
                'jenisKendaraan' => 'Mobil',
                'merekKendaraan' => 'Toyota Avanza 2021',
                'jenisService' => ['Ganti Oli', 'Diagnosa Mesin'],
                'tanggalService' => '2026-04-22',
                'jamService' => '09:00',
                'estimasiBiaya' => 600000,
                'estimasiDurasi' => 75,
                'statusBooking' => 'Diproses',
            ],
            [
                'kodeBooking' => 'PS-002',
                'namaPelanggan' => 'Siti Aminah',
                'nomorPlat' => 'D 5678 ABC',
                'jenisKendaraan' => 'SUV',
                'merekKendaraan' => 'Honda HR-V 2020',
                'jenisService' => ['Servis Berkala'],
                'tanggalService' => '2026-04-22',
                'jamService' => '11:00',
                'estimasiBiaya' => 850000,
                'estimasiDurasi' => 120,
                'statusBooking' => 'Menunggu',
            ],
            [
                'kodeBooking' => 'PS-003',
                'namaPelanggan' => 'Raka Pratama',
                'nomorPlat' => 'F 9012 IJ',
                'jenisKendaraan' => 'Motor',
                'merekKendaraan' => 'Yamaha NMAX 2022',
                'jenisService' => ['Perbaikan Rem', 'Ganti Oli'],
                'tanggalService' => '2026-04-23',
                'jamService' => '13:00',
                'estimasiBiaya' => 625000,
                'estimasiDurasi' => 90,
                'statusBooking' => 'Selesai',
            ],
        ];
    }
}
