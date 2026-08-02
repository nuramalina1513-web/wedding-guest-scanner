<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\view\view;

class GuestController extends Controller
{
    public function show(string $code): View
    {
        $guest = Guest::where('code', $code)->firstOrFail();

        return view('guests.show', compact('guest'));
    }
}
