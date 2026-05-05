<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'slot',
        'start_time',
        'end_time',
        'jenis_kendaraan',
        'merek_kendaraan',
        'nomor_plat',
        'total_estimasi_harga',
        'total_estimasi_durasi',
        'status',
        'pesan',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_estimasi_harga' => 'integer',
        'total_estimasi_durasi' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function layanans(): BelongsToMany
    {
        return $this->belongsToMany(
            Layanan::class,
            'booking_layanan'
        )->withTimestamps();
    }
}
