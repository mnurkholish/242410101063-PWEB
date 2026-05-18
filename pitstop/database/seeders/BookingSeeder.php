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
        $layanans = Layanan::aktif()->orderBy('nama')->get();

        if ($layanans->isEmpty()) {
            return;
        }

        $users = collect([
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@pitstop.test',
            ],
            [
                'name' => 'Sari Wulandari',
                'email' => 'sari@pitstop.test',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@pitstop.test',
            ],
            [
                'name' => 'Pelanggan PitStop',
                'email' => 'pelanggan@pitstop.test',
            ],
        ])->map(fn (array $user) => User::updateOrCreate(
            ['email' => $user['email']],
            [
                'name' => $user['name'],
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
            ],
        ));

        Booking::query()
            ->whereIn('user_id', $users->pluck('id'))
            ->delete();

        $items = [
            [
                'user' => 'budi@pitstop.test',
                'slot' => 'A',
                'start_time' => now()->addDay()->setTime(9, 0),
                'jenis_kendaraan' => 'Mobil',
                'merek_kendaraan' => 'Toyota Avanza 2021',
                'nomor_plat' => 'B 1234 XYZ',
                'status' => 'pending',
                'pesan' => 'Tolong cek rem depan karena mulai berbunyi.',
                'layanan' => ['Ganti Oli', 'Perbaikan Rem'],
            ],
            [
                'user' => 'sari@pitstop.test',
                'slot' => 'B',
                'start_time' => now()->addDays(2)->setTime(11, 0),
                'jenis_kendaraan' => 'SUV',
                'merek_kendaraan' => 'Honda HR-V 2020',
                'nomor_plat' => 'D 5678 ABC',
                'status' => 'diproses',
                'pesan' => 'Kendaraan dipakai harian, mohon cek kondisi umum.',
                'layanan' => ['Servis Berkala', 'Spooring & Balancing'],
            ],
            [
                'user' => 'andi@pitstop.test',
                'slot' => 'C',
                'start_time' => now()->addDays(3)->setTime(13, 30),
                'jenis_kendaraan' => 'Motor',
                'merek_kendaraan' => 'Yamaha NMAX 2022',
                'nomor_plat' => 'P 2468 MN',
                'status' => 'pending',
                'pesan' => null,
                'layanan' => ['Ganti Oli', 'Diagnosa Mesin'],
            ],
            [
                'user' => 'pelanggan@pitstop.test',
                'slot' => 'A',
                'start_time' => now()->subDays(2)->setTime(10, 0),
                'jenis_kendaraan' => 'Pickup',
                'merek_kendaraan' => 'Mitsubishi L300 2019',
                'nomor_plat' => 'N 8899 TR',
                'status' => 'selesai',
                'pesan' => 'Selesai servis untuk kebutuhan operasional toko.',
                'layanan' => ['Tune Up Mesin', 'Cuci Mobil Premium'],
            ],
            [
                'user' => 'budi@pitstop.test',
                'slot' => 'B',
                'start_time' => now()->subDay()->setTime(14, 0),
                'jenis_kendaraan' => 'Mobil',
                'merek_kendaraan' => 'Daihatsu Xenia 2018',
                'nomor_plat' => 'L 4321 CD',
                'status' => 'dibatalkan',
                'pesan' => 'Pelanggan mengubah jadwal servis.',
                'layanan' => ['Servis AC'],
            ],
            [
                'user' => 'sari@pitstop.test',
                'slot' => 'C',
                'start_time' => now()->addDays(4)->setTime(8, 30),
                'jenis_kendaraan' => 'Mobil',
                'merek_kendaraan' => 'Suzuki Ertiga 2023',
                'nomor_plat' => 'B 7788 SR',
                'status' => 'pending',
                'pesan' => 'Cek AC dan bersihkan interior sekalian.',
                'layanan' => ['Servis AC', 'Cuci Mobil Premium'],
            ],
        ];

        foreach ($items as $item) {
            $user = $users->firstWhere('email', $item['user']);
            $selectedLayanans = collect($item['layanan'])
                ->map(fn (string $nama) => $layanans->firstWhere('nama', $nama))
                ->filter()
                ->values();

            if ($selectedLayanans->isEmpty()) {
                $selectedLayanans = $layanans->take(1)->values();
            }

            if (! $user || $selectedLayanans->isEmpty()) {
                continue;
            }

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
                'pesan' => $item['pesan'],
            ]);

            $booking->layanans()->attach($selectedLayanans->pluck('id'));
        }
    }
}
