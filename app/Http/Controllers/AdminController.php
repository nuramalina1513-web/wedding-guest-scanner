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

        $lastCode = Guest::where('code', 'like', 'WED-ARIFA-%')
        ->orderBy('code', 'desc')
        ->value('code');

        $nextNumber = $lastCode
        ? ((int) substr($lastCode, -3)) + 1
        : 1;

        $code = 'WED-ARIFA-' .str_pad(
            $nextNumber, 
            3, 
            '0', 
            STR_PAD_LEFT
            );

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
                'message' => "Data Tamu berhasil Ditemukan.",
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

    public function importGuests(): View
    {
        return view('admin.guests.import');
    }

    public function storeImportGuests(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        //lewati header csv
        fgetcsv($handle);

        $importedCount = 0;

        while (($row = fgetcsv($handle)) !== false){

        if (count($row) < 3){
            continue;
        }

        $name= trim($row[0]);
        $guestType = strtolower(trim($row[1]));
        $invitationLimit = (int) trim($row[2]);

        if (
            $name === '' ||
            ! in_array($guestType, ['reguler', 'vip']) ||
            $invitationLimit < 1
        ) {
            continue;
        }

        $lastCode = Guest::where('code', 'like', 'WED-ARIFA-%')
        ->orderBy('code', 'desc')
        ->value('code');

        $nextNumber = $lastCode
        ? ((int) substr($lastCode, -3)) + 1
        : 1;

        $code = 'WED-ARIFA-' . str_pad(
            $nextNumber,
            3,
            '0',
            STR_PAD_LEFT
        );

        Guest::create([
            'name' => $name,
            'code' => $code,
            'guest_type' => $guestType,
            'invitation_limit' => $invitationLimit,
            'attended_count' => 0,
            'scanned_at' => null,
        ]);

        $importedCount++;
        }

        fclose($handle);

        return redirect()
        ->route('admin.guests.index')
        ->with(
            'success',
            $importedCount . ' tamu berhasil diimport.'
        );
    }

    public function resetCheckIn(Guest $guest)
    {
        $guest->update([
            'attended_count'=> 0,
            'scanned_at' => null,
        ]);

        return redirect ()
            ->route('admin.guests.index')
            ->with(
                'success',
                'Check-in tamu ' . $guest->name . ' berhasil direset.'
            );
    }

    public function exportGuests()
    {
        $guests = Guest::orderBy('id', 'asc')->get();

        $fileName = 'daftar-tamu.csv';

        return response()->streamDownload(function () use ($guests) {

        $handle = fopen('php://output', 'w');

        //supaya karakter terbaca baik diexcel
        fwrite($handle, "\XEF\XBB\XBF");

        //header csv
        fputcsv($handle, [
            'Nama',
            'Kode Qr',
            'Tipe',
            'Batas Undangan',
            'Jumlah Hadir',
            'Status',
            'Waktu Check-in',
        ]);

        foreach ($guests as $guest) {

            fputcsv($handle, [
                $guest->name,
                $guest->code,
                strtoupper($guest->guest_type ?? '-'),
                $guest->invitation_limit,
                $guest->attended_count,
                $guest->scanned_at ? 'Sudah Check-in' : 'Belum Check-in',
                $guest->scanned_at
                ? $guest->scanned_at->format('d-m-y H:i:s')
                : '-',
            ]);
        }

        fclose($handle);

        }, $fileName, [
            'content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

}
