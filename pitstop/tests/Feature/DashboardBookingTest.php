<?php

use App\Models\Booking;
use App\Models\User;

test('dashboard only shows bookings owned by authenticated user', function () {
    $user = User::factory()->create(['name' => 'Pemilik Booking']);
    $otherUser = User::factory()->create(['name' => 'User Lain']);

    Booking::create([
        'user_id' => $user->id,
        'slot' => 'A',
        'start_time' => now()->addDay()->setTime(9, 0),
        'end_time' => now()->addDay()->setTime(10, 0),
        'jenis_kendaraan' => 'Mobil',
        'merek_kendaraan' => 'Toyota Avanza',
        'nomor_plat' => 'B 1234 ABC',
        'total_estimasi_harga' => 350000,
        'total_estimasi_durasi' => 60,
        'status' => 'pending',
    ]);

    Booking::create([
        'user_id' => $otherUser->id,
        'slot' => 'B',
        'start_time' => now()->addDay()->setTime(11, 0),
        'end_time' => now()->addDay()->setTime(12, 0),
        'jenis_kendaraan' => 'Motor',
        'merek_kendaraan' => 'Yamaha NMAX',
        'nomor_plat' => 'D 5678 XYZ',
        'total_estimasi_harga' => 250000,
        'total_estimasi_durasi' => 45,
        'status' => 'diproses',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response
        ->assertOk()
        ->assertSee('Toyota Avanza')
        ->assertDontSee('Yamaha NMAX');
});
