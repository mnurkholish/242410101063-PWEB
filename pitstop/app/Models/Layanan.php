<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Layanan extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'estimasi_harga',
        'estimasi_durasi',
        'gambar',
        'is_active',
    ];

    protected $casts = [
        'estimasi_harga' => 'integer',
        'estimasi_durasi' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeAktif(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(
            Booking::class,
            'booking_layanan'
        )->withTimestamps();
    }
}
