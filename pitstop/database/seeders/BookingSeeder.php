<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Layanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'pelanggan@pitstop.test'],
            [
                'name' => 'Pelanggan PitStop',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
            ],
        );

        if (Booking::where('user_id', $user->id)->exists()) {
            return;
        }

        $layanans = Layanan::aktif()->orderBy('id')->take(4)->get();

        if ($layanans->isEmpty()) {
            return;
        }

        $items = [
            [
                'slot' => 'A',
                'start_time' => now()->addDay()->setTime(9, 0),
                'jenis_kendaraan' => 'Mobil',
                'merek_kendaraan' => 'Toyota Avanza 2021',
                'nomor_plat' => 'B 1234 XYZ',
                'status' => 'pending',
                'layanan_ids' => $layanans->take(2)->pluck('id'),
            ],
            [
                'slot' => 'B',
                'start_time' => now()->addDays(2)->setTime(11, 0),
                'jenis_kendaraan' => 'SUV',
                'merek_kendaraan' => 'Honda HR-V 2020',
                'nomor_plat' => 'D 5678 ABC',
                'status' => 'diproses',
                'layanan_ids' => $layanans->skip(1)->take(2)->pluck('id'),
            ],
        ];

        foreach ($items as $item) {
            $selectedLayanans = Layanan::whereIn('id', $item['layanan_ids'])->get();
            $totalDurasi = $selectedLayanans->sum('estimasi_durasi');
            $startTime = Carbon::parse($item['start_time']);

            $booking = Booking::create([
                'user_id' => $user->id,
                'slot' => $item['slot'],
                'start_time' => $startTime,
                'end_time' => $startTime->copy()->addMinutes($totalDurasi),
                'jenis_kendaraan' => $item['jenis_kendaraan'],
                'merek_kendaraan' => $item['merek_kendaraan'],
                'nomor_plat' => $item['nomor_plat'],
                'total_estimasi_harga' => $selectedLayanans->sum('estimasi_harga'),
                'total_estimasi_durasi' => $totalDurasi,
                'status' => $item['status'],
            ]);

            $booking->layanans()->attach($selectedLayanans->pluck('id'));
        }
    }
}
