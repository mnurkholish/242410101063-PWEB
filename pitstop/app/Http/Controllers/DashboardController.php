<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
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
}
