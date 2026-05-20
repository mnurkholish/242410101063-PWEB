<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Preferensi berhasil diterima.',
            'preferences' => [
                'theme' => $request->cookie('pitstop_theme', 'light'),
                'font_size' => $request->cookie('pitstop_font_size', 'normal'),
            ],
        ]);
    }
}
