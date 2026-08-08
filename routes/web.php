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
