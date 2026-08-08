<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.scan');
    }

    public function findGuest(string $code): JsonResponse
    {
        $guest = Guest::where('code', $code)->first();

        if (!$guest){
            return response()->json([
                'message' => "Data Tamu Tidak Ditemukan.",
            ], 404);
        }

        if ($guest->scanned_at) {
            return response()->json([
                'message' => 'Eits ... Tamu ini sudah di scan 😔',
                'guest' => $guest,
            ], 409);
        }

        return response()->json([
            'message' => 'Data Tamu Tidak Ditemukan.',
            'guest' => $guest,
        ]);
    }

    public function confirm(Request $request, string $code): JsonResponse
    {
        $guest = Guest::where('code', $code)->first();

        if (!$guest){
            return response()->json([
                'message' => 'Data tamu tidak ditemukan.',
            ], 404);
        }

        if ($guest->scanned_at){
            return response()->json([
                'message' => 'Eits ... Tamu ini sudah di scan 😔',
            ], 409);
        }

        $request->validate([
            'attended_count' => ['required', 'integer', 'min:1'],
        ]);

        if ($request->attended_count > $guest->invitation_limit){
            return response ()->json([
                'message' => 'Jumlah tamu yang dhadir melebihi batas undangan.',
            ], 422);
        }

        $guest->update([
            'attended_count' => $request->attended_count,
            'scanned_at' => now(),
        ]);

        return response()->json([
            'message' => 'Tamu berhasil di konfirmasi',
            'guest' => $guest->fresh(),
        ]);
    }
}
