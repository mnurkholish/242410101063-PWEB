<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pitstop.test'],
            [
                'name' => 'Admin PitStop',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
            ],
        );
    }
}
