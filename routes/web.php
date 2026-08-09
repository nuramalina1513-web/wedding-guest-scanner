<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tamu/{code}', [GuestController::class, 'show'])
->name('guest.show');

Route::get('/admin/scan', [AdminController::class, 'index'])
->name('admin.scan');

Route::get('/admin/guest/{code}', [AdminController::class, 'findGuest'])
->name('admin.guest.find');

Route::post('/admin/guest/{code}/confirm', [AdminController::class, 'confirm'])
->name('admin.guest.confirm');

Route::get('/admin/guests/create', [AdminController::class, 'createGuest'])
->name('admin.guests.create');

Route::post('/admin/guests', [AdminController::class, 'storeGuest'])
->name('admin.guests.store');

Route::get('/admin/guests', [AdminController::class, 'guestList'])
->name('admin.guests.index');

Route::get('/admin/guests/{guest}/edit', [AdminController::class, 'editGuest'])
->name('admin.guests.edit');

Route::put('/admin/guests/{guest}', [AdminController::class, 'updateGuest'])
->name('admin.guests.update');

Route::delete('/admin/guests/{guest}', [AdminController::class, 'deleteGuest'])
->name('admin.guests.delete');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
->name('admin.dashboard');

Route::get('/admin/guests/import', [AdminController::class, 'importGuests'])
->name('admin.guests.import');

Route::post('/admin/guests/import', [AdminController::class, 'storeImportGuests'])
->name('admin.guests.import.store');

Route::patch('/admin/guests/{guest}/reset-checkin', [AdminController::class, 'resetCheckIn'])
->name('admin.guests.reset-checkin');

Route::get('/admin/guests/export', [AdminController::class, 'exportGuests'])
->name('admin.guests.export');