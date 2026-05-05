<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanans = [
            [
                'nama' => 'Ganti Oli',
                'deskripsi' => 'Penggantian oli mesin dan pengecekan dasar kendaraan.',
                'estimasi_harga' => 350000,
                'estimasi_durasi' => 30,
                'gambar' => 'layanan/ganti-oli.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Servis Berkala',
                'deskripsi' => 'Pemeriksaan rutin kendaraan sesuai jadwal servis.',
                'estimasi_harga' => 850000,
                'estimasi_durasi' => 120,
                'gambar' => 'layanan/servis-berkala.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Tune Up Mesin',
                'deskripsi' => 'Penyetelan mesin untuk performa kendaraan lebih optimal.',
                'estimasi_harga' => 600000,
                'estimasi_durasi' => 90,
                'gambar' => 'layanan/tune-up.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Perbaikan Rem',
                'deskripsi' => 'Pemeriksaan dan perbaikan sistem pengereman kendaraan.',
                'estimasi_harga' => 275000,
                'estimasi_durasi' => 60,
                'gambar' => 'layanan/perbaikan-rem.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Spooring & Balancing',
                'deskripsi' => 'Menyeimbangkan roda dan meluruskan posisi ban kendaraan.',
                'estimasi_harga' => 450000,
                'estimasi_durasi' => 60,
                'gambar' => 'layanan/spooring.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Cuci Mobil Premium',
                'deskripsi' => 'Pembersihan kendaraan bagian luar dan dalam.',
                'estimasi_harga' => 150000,
                'estimasi_durasi' => 45,
                'gambar' => 'layanan/cuci-premium.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Diagnosa Mesin',
                'deskripsi' => 'Pengecekan mesin menggunakan alat scanner modern.',
                'estimasi_harga' => 250000,
                'estimasi_durasi' => 45,
                'gambar' => 'layanan/diagnosa.jpg',
                'is_active' => true,
            ],
            [
                'nama' => 'Servis AC',
                'deskripsi' => 'Pembersihan dan pengecekan sistem pendingin kendaraan.',
                'estimasi_harga' => 400000,
                'estimasi_durasi' => 75,
                'gambar' => 'layanan/service-ac.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}
