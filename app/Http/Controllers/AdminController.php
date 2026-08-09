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

    public function createGuest(): View
    {
        return view('admin.guests.create');
    }

    public function storeGuest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'guest_type' => 'required|in:reguler,vip',
            'invitation_limit' => 'required|integer|min:1',
        ]);

        $lastGuest = Guest::orderBy('id', 'desc')->first();

        $nextNumber = $lastGuest
        ? $lastGuest->id + 1
        : 1;

        $code = 'WED-ARIFA-' .str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $guest = Guest::create([
            'name' => $validated['name'],
            'code' => $code,
            'guest_type' => $validated['guest_type'],
            'invitation_limit' => $validated['invitation_limit'],
            'attended_count' => 0,
            'scanned_at' => null,
        ]);

        return redirect()
        ->route('admin.guests.create')
        ->with('success', 'Tamu berhasil ditambahkan dengan kode ' . $code)
        ->with('guest_code', $guest->code);
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

    public function guestList(): view
    {
        $guests = Guest::orderBy('id', 'desc')->get();

        return view('admin.guests.index', compact('guests'));
    }

    public function editGuest(Guest $guest): view
    {
        return view('admin.guests.edit', compact('guest'));
    }

    public function updateGuest(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'guest_type' => 'required|in:reguler,vip',
            'invitation_limit' => 'required|integer|min:1',
        ]);

        $guest->update([
            'name' => $validated['name'],
            'guest_type' => $validated['guest_type'],
            'invitation_limit' => $validated['invitation_limit'],
        ]);

        return redirect()
            ->route('admin.guests.index')
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function deleteGuest(Guest $guest)
    {
        $guestName = $guest->name;

        $guest->delete();

        return redirect()
        ->route('admin.guests.index')
        ->with('success', 'Tamu ' . $guestName . ' berhasil dihapus.');
    }

    public function dashboard(): view
    {
        $totalGuests = Guest::count();

        $totalInvitation = Guest::sum('invitation_limit');

        $checkedIn = Guest::whereNotNull('scanned_at')->count();

        $notCheckedIn = Guest::whereNull('scanned_at')->count();

        $totalAttended = Guest::sum('attended_count');

        $totalVip = Guest::where('guest_type', 'vip')->count();

        $totalReguler = Guest::where('guest_type', 'reguler')->count();

        return view('admin.dashboard', compact(
        'totalGuests',
        'totalInvitation',
        'checkedIn',
        'notCheckedIn',
        'totalAttended',
        'totalVip',
        'totalReguler'
        ));

    }

}
