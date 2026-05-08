<?php

namespace Database\Factories;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Layanan>
 */
class LayananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => implode(' ', fake()->words(2)),
            'deskripsi' => fake()->text(200),
            'estimasi_harga' => fake()->randomElement(range(10000, 10000000, 10000)),
            'estimasi_durasi' => fake()->randomElement(range(10, 300, 10)),
            'gambar' => null,
            'is_active' => true,
            'created_at' => fake()->dateTimeBetween('-5 years')
        ];
    }
}
