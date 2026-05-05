<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
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
