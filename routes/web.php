<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tamu/{code}', [GuestController::class, 'show'])
->name('guest.show');
